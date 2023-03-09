<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Config\Option;

/** @var CBitrixComponent
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 * @var string $conmpnentName
 * @global CDatabase $DB
 * @global CUser $USER
 */
/** @global CMain $APPLICATION */


$arResult = array();
$arRes = array();

//create new office if no exist
$arResult['CREATE_ELEMENTS'] = [];
$arResult['ERROR'] = [];
$arResult['ERROR'] = [];

//check site template
if(SITE_TEMPLATE_ID !== 'contact'){
    $arResult['ERROR'][] = GetMessage('ROMANOVV_SET_TMPL_CONTACTS'). SITE_TEMPLATE_ID;
}
$isCreatedEl = Option::get('romanovv.contact', 'create_elements');

//create demo elements
if (!$isCreatedEl) {

    $obFabricContact = new \VadimRomanov\FabricContacts();
    $resCreateEl = $obFabricContact->create();

    $arResult['MSG'] = (isset($resCreateEl['MSG'])) ? implode('<br>', $resCreateEl['MSG']) : '';
    $arResult['ERROR'][] =  $resCreateEl['ERROR'];

    if ($resCreateEl['STATUS'] === 'allCreated') {

        Option::set('romanovv.contact', 'create_elements', 'Y');
        $isCreatedEl = 'Y';
    }
}
$arResult['ERROR'] = implode('<br>', $arResult['ERROR']);



if ($isCreatedEl) {

    $arParams["CACHE_TIME"] = 86400;
    $arRes["CUR_PAGE"] = $APPLICATION->GetCurPage(false);

    $arRes["ORDER"] = array(
        "SORT" => "ASC"
    );
    $arRes["FILTER"] = array(
        "ACTIVE" => "Y",
    );

    $arRes["SELECT"] = array(
        'ID',
        'IBLOCK_ID',
        'NAME',
        'PHONE',
        'EMAIL',
        'COORDS',
        'CITY'
    );

    $CACHE_ID = serialize(array($arRes["CUR_PAGE"], $arRes["SELECT"], $arRes["FILTER"]));

    if ($this->startResultCache($arParams["CACHE_TIME"], $CACHE_ID)) {
        $helperIblock = new \VadimRomanov\HelperIblock();
        try{
            $iblockTableName = $helperIblock->getTablePathIblock('contacts');
            $elements = $iblockTableName::getList([
                'select' => $arRes['SELECT'],
                'order' => $arRes['ORDER'],
                'filter' => $arRes['FILTER'],
            ])->fetchCollection();

            foreach ($elements as $element) {
                $el = [];
                $el['ID'] = $element->getID();
                $el['NAME'] = $element->getName();
                $el['PHONE'] = $element->get('PHONE')->getValue();
                $el['EMAIL'] = $element->get('EMAIL')->getValue();
                $el['COORDS'] = $element->get('COORDS')->getValue();
                $el['CITY'] = $element->get('CITY')->getValue();
                $arResult['ITEMS'][] = $el;
            }

            $this->SetResultCacheKeys(array(
                    "ID",
                    "NAME",
                    "PHONE",
                    "EMAIL",
                    "COORDS",
                    "CITY",
                )
            );
            $this->EndResultCache();
        }catch (Exception $e){
            $arResult['ERROR'] = $e->getMessage();
        }

    }
}

$this->IncludeComponentTemplate();