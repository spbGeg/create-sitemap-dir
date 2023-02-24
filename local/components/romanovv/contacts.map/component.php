<?php



if( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
    die();
}


/** @var CBitrixComponent
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 * @var string $conmpnentName
 * @global CDatabase $DB
 * @global CUser $USER
 * @global CMain $APLICATION
 */

$arResult = array();
$arRes = array();
$arParameters = array();


$arParams["CACHE_TIME"] = ($USER->IsAdmin()) ? 1 : 86400;
$arRes["CUR_PAGE"] = $APPLICATION->GetCurPage(false);

$arRes["SORT"] = array(
    "SORT" => "ASC"
);
$arRes["FILTER"] = array(
    "IBLOCK_ID" => 6,
    "ACTIVE" => "Y",
);

$arRes["SELECT"] = array(
    'NAME',
    'CODE',
    'ID'
);
$CACHE_ID = serialize(array($arRes["CUR_PAGE_FULL"], $arRes["SELECT"], $arRes["FILTER"]));

if($this->startResultCache($arParams["CACHE_TIME"], $CACHE_ID)){
//    $res = \CIBLockElement::GetList($arRes["SORT"], $arRes["FILTER"], false, array(), $arRes["SELECT"]);
//    while($ob = $res->Fetch()){
//        $arResult[$ob["ID"]] = $ob;
//    }

    $this->SetResultCacheKeys(array(
            "",
        )
    );
    $this->EndResultCache();

}

//MyService::dumpConsole('==category=');
//MyService::dumpConsole($arResult);
$this->IncludeComponentTemplate();