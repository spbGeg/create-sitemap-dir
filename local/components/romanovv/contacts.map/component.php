<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Config\Option;
use Bitrix\Main\Application;

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
$arParameters = array();

//create new office if no exist
$arResult['CREATE_ELEMENTS'] = [];

$isCreateEl = Option::get('romanovv_contact', 'create_elements');
if (!$isCreateEl) {

    $obFabricContact = new \VadimRomanov\FabricContacts();
    $resCreateEl = $obFabricContact->fabricOffice();
    $arResult['CREATE_ELEMENTS']['MSG'] = implode('<br>', $resCreateEl['MSG']);
    $arResult['CREATE_ELEMENTS']['ERROR'] = implode(', ', $resCreateEl['ERROR']);

    if ($resCreateEl['STATUS'] === 'allCreated') {
        Option::set('romanovv_contact', 'create_elements', true);
    }
}


$arParams["CACHE_TIME"] =  86400;
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

$issetCache = $this->startResultCache($arParams["CACHE_TIME"], $CACHE_ID);
\VadimRomanov\Tools::logFile($issetCache, '$issetCache contact');

if ($issetCache) {
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

$this->IncludeComponentTemplate();