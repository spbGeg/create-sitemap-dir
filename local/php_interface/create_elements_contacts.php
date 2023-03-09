<?php

$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__) . '/../../');
define('LANG', 's1');
define('SITE_ID', 's1');
define("NO_KEEP_STATISTIC", true);

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('main');

$obFabricContact = new \VadimRomanov\FabricContacts();
$resCreateEl = $obFabricContact->create();

if(isset($resCreateEl['MSG']) && !empty($resCreateEl['MSG'])){
    foreach ($resCreateEl['MSG'] as $item){
        echo $item . PHP_EOL;
    }
}
if(isset($resCreateEl['ERROR']) && !empty($resCreateEl['ERROR'])){
    foreach ($resCreateEl['MSG'] as $item){
        echo $item . PHP_EOL;
    }
}


@set_time_limit(30000);
ini_set('max_execution_time', 30000);




