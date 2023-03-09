<?php
/**
 *
 * @author romanovv
 * @copyright romanovv
 * @version 1.0.0
 *
 */
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
$path = \Bitrix\Main\Loader::getLocal('modules/romanovv.sitemap/admin/romanovv_sitemap_generate.php');
if(file_exists($path)) {
    include $path;
} else {
    ShowMessage('file romanovv_sitemap_generate.php not found!');
}
?>