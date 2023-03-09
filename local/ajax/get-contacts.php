<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


use \Bitrix\Main\Data\Cache;
use \Bitrix\Main\Application;

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

$cache = Cache::createInstance(); // Служба кеширования
$taggedCache = Application::getInstance()->getTaggedCache();
$cachePath = 'contacts-path';
$cacheTtl = 86400;

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

try {

    if ($cache->initCache($cacheTtl, $CACHE_ID, $cachePath)) {

        $arResult = $cache->getVars();

    } elseif ($cache->startDataCache()) {

        $taggedCache->startTagcache($cachePath);

        $arResult['RAND'] = rand(0, 20);

        $helperIblock = new \VadimRomanov\HelperIblock();
        $iblockTableName = $helperIblock->getTablePathIblock('contacts');
        $contactsIblockId = '';

        $elements = $iblockTableName::getList([
            'select' => $arRes['SELECT'],
            'order' => $arRes['ORDER'],
            'filter' => $arRes['FILTER'],
        ])->fetchCollection();


        //Кешируемый код
        $arResult['COUNT_TOTAL'] = $elements->count();
        if (!$arResult['COUNT_TOTAL']) {
            $taggedCache->abortTagCache();
            $cache->abortDataCache();
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

            if (!$contactsIblockId) {
                $contactsIblockId = $element->get('IBLOCK_ID');
            }
        }
        $taggedCache->registerTag('iblock_id_' . $contactsIblockId);
        $taggedCache->endTagCache();
        $cache->endDataCache($arResult);


    }
} catch (Exception $e) {
    $arResult['ERROR'] = $e->getMessage();
} finally{

    return $arResult;

}