<?php
/**
 * @author Vadim Romanov
 * @copyright Vadim Romanov
 * @version 0.0.1
 *
 */
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
use \Bitrix\Main\ModuleManager;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

Loader::registerAutoLoadClasses(
    "romanovv.sitemap",
    [
        "RomanovvSitemap" => '/include.php',
    ]
);


class romanovv_sitemap extends CModule
{
    var $MODULE_ID = "romanovv.sitemap";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_GROUP_RIGHTS = "Y";
    var $PARTNER_NAME = 'romanovv';

    public function __construct()
    {
        $arModuleVersion = [];

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage("ROMANOVV_SITEMAP_MODULE_NAME_SITEMAP");
        $this->MODULE_DESCRIPTION = Loc::getMessage("ROMANOVV_SITEMAP_MODULE_DESCRIPTION_SITEMAP");

    }
    public function doInstall(): bool
    {
        global $APPLICATION;
        if (!check_bitrix_sessid()) {
            return false;
        }
        try{
            $this->registerEvents();
            $this->installFiles();
            ModuleManager::registerModule($this->MODULE_ID);

        }catch (Exception $e){

            $GLOBALS['ROMANOVV_SITEMAP_ERROR'] = $e->getMessage();
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage("ROMANOVV_SITEMAP_STEP_ERROR"),
                __DIR__ . "/error.php"
            );
            return false;
        }
        return true;
    }

    public function doUninstall(): bool
    {
        global $APPLICATION;
        if (!check_bitrix_sessid()) {
            return false;
        }
        try{

            $this->unRegisterEvents();
            $this->deleteFiles();
            ModuleManager::unRegisterModule($this->MODULE_ID);

        }catch (Exception $e){

            $GLOBALS['ROMANOVV_SITEMAP_ERROR'] = $e->getMessage();
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage("ROMANOVV_SITEMAP_STEP_ERROR"),
                __DIR__ . "/error.php"
            );
            return false;
        }
        return true;
    }


    private function registerEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandler("main", "OnBuildGlobalMenu", $this->MODULE_ID, "RomanovvSitemap", "DoBuildGlobalMenu");
        return true;
    }

    private function unRegisterEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler("main", "OnBuildGlobalMenu", $this->MODULE_ID);
        return true;
    }

    public function installFiles()
    {

        // copy themes files
        if (!CopyDirFiles(__DIR__ . "/themes", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/themes", true, true)) {
            throw new Exception(Loc::getMessage("ERRORS_SAVE_FILE", ['#DIR#' => 'bitrix/themes']));
        }

        // copy admin files
        if (!CopyDirFiles(__DIR__ . "/admin", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin", true, true)) {
            throw new Exception(Loc::getMessage("ERRORS_SAVE_FILE", ['#DIR#' => 'bitrix/admin']));
        }

        // copy components files
        if (!CopyDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/{$this->MODULE_ID}/install/components", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components", true, true)) {
            CAdminMessage::ShowMessage(Loc::getMessage("ERRORS_SAVE_FILE", ['#DIR#' => __DIR__ . "bitrix/components"]));
        }



        return true;
    }
    public function deleteFiles()
    {
        DeleteDirFilesEx('/bitrix/admin/romanovv-sitemap-generate.php');
        DeleteDirFilesEx('/bitrix/admin/romanovv-sitemap-generate.php');
        DeleteDirFilesEx('/bitrix/components/romanovv/sitemap.generator');
        DeleteDirFilesEx('/bitrix/themes/.default/romanovv.sitemap.css');

        return true;
    }

}