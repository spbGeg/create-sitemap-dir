<?php
define('ADMIN_MODULE_NAME', 'romanovv.sitemap');

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;
/**
 * @global CUser $USER
 * @global CMain $APPLICATION
 **/

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

if( ! Loader::IncludeModule(ADMIN_MODULE_NAME)){
    echo ADMIN_MODULE_NAME;
    throw new SystemException(ADMIN_MODULE_NAME. ' not installed');
}

/** @var \CAllMain $APPLICATION */
$APPLICATION->IncludeComponent("romanovv:sitemap.generator", "", []);

?>




