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
if(SITE_TEMPLATE_ID !== 'contacts'){
    $arResult['ERROR'][] = GetMessage('ROMANOVV_SET_TMPL_CONTACTS');
}
$isCreatedEl = Option::get('romanovv.contact', 'create_elements');

if (!$isCreatedEl) {
    $obFabricContact = new \VadimRomanov\FabricContacts();
    $resCreateEl = $obFabricContact->fabricOffice();

    $arResult['CREATE_ELEMENTS']['STATUS'] =  $resCreateEl['STATUS'];
    $arResult['MSG'] = implode('<br>', $resCreateEl['MSG']);
    $arResult['ERROR'] = array_merge($arResult['ERROR'],  $resCreateEl['ERROR']);

    if ($arResult['CREATE_ELEMENTS']['STATUS'] === 'allCreated') {
        Option::set('romanovv.contact', 'create_elements', 'Y');
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
        $iblockTableName = $helperIblock->getTablePathIblock('contacts');

        $elements = $iblockTableName::getList([
            'select' => $arRes['SELECT'],
            'order' => $arRes['ORDER'],
            'filter' => $arRes['FILTER'],
            "cache" => [
                "ttl" => $arParams["CACHE_TIME"],
            ],
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

    }
}

$this->IncludeComponentTemplate();