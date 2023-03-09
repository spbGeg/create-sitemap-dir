<?php defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
/** @author Vadim Romanov  */
use Bitrix\Main\Loader;

if(!check_bitrix_sessid()) return;

IncludeModuleLangFile(__FILE__);

Loader::includeModule('main');

CAdminMessage::ShowMessage(array(
    "MESSAGE"=>$GLOBALS['ROMANOVV_SITEMAP_ERROR'],
    "TYPE"=>"ERROR"
));

echo BeginNote();
echo $GLOBALS['ROMANOVV_SITEMAP_ERROR_NOTES'];
echo EndNote();