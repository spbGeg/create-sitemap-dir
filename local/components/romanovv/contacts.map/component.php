<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}







/*


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
    $arResult['RAND'] = rand(0, 20);
    $helperIblock = new \VadimRomanov\HelperIblock();
    try {
        $iblockTableName = $helperIblock->getTablePathIblock('contacts');
        $elements = $iblockTableName::getList([
            'select' => $arRes['SELECT'],
            'order' => $arRes['ORDER'],
            'filter' => $arRes['FILTER'],
        ])->fetchCollection();


        //Кешируемый код
        $arResult['COUNT_TOTAL'] = $elements->count();
        if (!$arResult['COUNT_TOTAL'])
        {
            $this->AbortResultCache();
            return;
        }
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
                "CITY"
            )
        );
        $this->EndResultCache();
    } catch (Exception $e) {
        $arResult['ERROR'] = $e->getMessage();
    }


}

*/

$this->IncludeComponentTemplate();