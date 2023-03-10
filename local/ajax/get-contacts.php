<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';


use \Bitrix\Main\Data\Cache;
use \Bitrix\Main\Application;

/** @global CMain $APPLICATION */
try {

    $response = array();
    $arRes = array();
    $response['success'] = false;
    $cache = Cache::createInstance();
    $taggedCache = Application::getInstance()->getTaggedCache();
    $cachePath = 'contacts-path';
    $cacheTtl = 86400;
    $cacheKey = 'contactsKey';

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


    if ($cache->initCache($cacheTtl, $cacheKey, $cachePath)) {

        $response = $cache->getVars();

    } elseif ($cache->startDataCache()) {
        $taggedCache->startTagcache($cachePath);

        $response['RAND'] = rand(0, 20);

        $helperIblock = new \VadimRomanov\HelperIblock();
        $iblockTableName = $helperIblock->getTablePathIblock('contacts');
        $contactsIblockId = '';

        $elements = $iblockTableName::getList([
            'select' => $arRes['SELECT'],
            'order' => $arRes['ORDER'],
            'filter' => $arRes['FILTER'],

        ])->fetchCollection();

        $response['count'] = $elements->count();
        if (!$response['count']) {
            $taggedCache->abortTagCache();
            $cache->abortDataCache();
            $response['error'] = 'Элементов не найдено';
            return;
        }
        foreach ($elements as $element) {
            $el = [];
            $el['id'] = $element->getID();
            $el['name'] = $element->getName();
            $el['phone'] = $element->get('PHONE')->getValue();
            $el['email'] = $element->get('EMAIL')->getValue();
            $el['coords'] = $element->get('COORDS')->getValue();
            $el['city'] = $element->get('CITY')->getValue();
            $response['items'][] = $el;

            if (!$contactsIblockId) {
                $contactsIblockId = $element->get('IBLOCK_ID');
            }
        }
        $response['success'] = true;

        $taggedCache->registerTag('iblock_id_' . $contactsIblockId);
        $taggedCache->endTagCache();
        $cache->endDataCache($response);


    }
} catch (Exception $e) {

    $response['error'] = $e->getMessage();

} finally {
    print json_encode($response, JSON_UNESCAPED_UNICODE);
}