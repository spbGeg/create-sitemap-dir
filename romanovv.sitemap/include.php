<?php defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

/** @author Vadim Romanov  */


use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
Loader::registerAutoLoadClasses(
    "romanovv.sitemap",
    [
        "Romanovv\Sitemap\AdminGenSitemap" => 'lib/AdminGenSitemap.php',
    ]
);

class RomanovvSitemap
{
    const MODULE_ID = 'romanovv.sitemap';
    const PATH_SITEMAP = '/sitemap-directory-files.xml';

    public static function DoBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
    {

        $aModuleMenu[] = [
            "parent_menu" => "global_menu_settings",
            "icon" => "romanovv_sitemap_menu_icon",
            "page_icon" => "romanovv_sitemap_page_icon",
            "sort" => "900",
            "text" => Loc::getMessage("ROMANOVV_SITEMAP_MENU_TEXT"),
            "title" => Loc::getMessage("ROMANOVV_SITEMAP_MENU_TITLE"),
            "url" => "/bitrix/admin/romanovv_sitemap_generate.php",
            "items_id" => "menu_romanovv_sitemap",
            "section" => "romanovv_sitemap",
            "more_url" => [],
        ];
    }
}