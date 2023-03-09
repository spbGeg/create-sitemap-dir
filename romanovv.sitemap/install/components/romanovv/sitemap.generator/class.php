<?php

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\IO;
use Bitrix\Main\Application;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

class GenSitemap extends CBitrixComponent
{
    var $SITEMAP_PATH;
    public function executeComponent()
    {
        global $USER;
        if (!Main\Loader::includeModule(ADMIN_MODULE_NAME)) {
            ShowError(Loc::getMessage('ROMANOVV_SITEMAP_MODULE_NOT_INSTALLED'));
            return;
        }

        if (!$USER->IsAdmin()) {
            ShowError(Loc::getMessage('ROMANOVV_SITEMAP_PERMISSION_DENIED'));
            return;
        }

        $this->arResult['PATH_FOLDER'] = $this->getPathFolder();

        $app = Application::getInstance();
        $context = $app->getContext();
        $request = $context->getRequest();

        //generate sitemap
        if ($request->getPost('generate-sitemap') && check_bitrix_sessid()) {
            if($path = $this->arResult['PATH_FOLDER']){
                $this->SITEMAP_PATH = Option::get(ADMIN_MODULE_NAME, 'path_sitemap');
                $result = $this->generateSitemap($path);

                if($result)
                    CAdminMessage::showMessage([
                        'MESSAGE' => GetMessage('ROMANOVV_SITEMAP_SITEMAP_GEN_SUCCESS'),
                        'TYPE' => 'OK',
                    ]);

            }else{
                ShowError(Loc::getMessage('ROMANOVV_SITEMAP_PATH_FOLDER_NOT_EXIST'));
            }
        }

        $this->IncludeComponentTemplate();
    }



    /**
     * Get protocol
     * @return string
     */
    private function getProtocol()
    {
        $protocol = 'http';
        if (\CMain::IsHTTPS()) {
            $protocol .= 's';
        }
        return ($protocol . '://');
    }

    /**
     * Get domain
     * @return mixed
     */
    private function getHost()
    {
        $host = \SITE_SERVER_NAME;
        if (!$host) {
            $host = $_SERVER['HTTP_HOST'];
        }
        return $host;
    }

    /**
     * Get url
     * @param string $path
     * @return bool|string
     */
    private function getUrl($path = '')
    {
        if (!$path) return false;
        return $this->getProtocol() . $this->getHost() . $path;
    }

    private function generateSitemap($path)
    {
        $dir = new IO\Directory(Application::getDocumentRoot().$path);
        $arObjFiles = $dir->getChildren();


        if(!empty($arObjFiles)){

            $fullPathDir = $this->getUrl($path);

            $allowExtString = $this->getAllowExt();
            $arAllowExt = array_map('trim', explode(',', $allowExtString));

            \X\Helpers\Log::logFile($arAllowExt, '$arAllowExt in class site gen');

            $out = '<?xml version="1.0" encoding="UTF-8"?>
                    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            foreach ($arObjFiles as $file){
                $fileName = $file->getName();
                $fileExt = IO\Path::getExtension($fullPathDir .$fileName);

                //escape if is folder
                if(!$fileExt) continue;

                if(in_array($fileExt, $arAllowExt)) {

                    $modifiedAt = $file->getModificationTime();

                    $out .= '<url>
                            <loc>' . $fullPathDir . $fileName . '</loc>
                            <lastmod>' . date('c', $modifiedAt) . '</lastmod>
                            <priority>' . $this->getPriority($modifiedAt) . '</priority>
                        </url>';
                }

            }
            $out .= '</urlset>';

            //save file sitemap
            $file = new IO\File(Application::getDocumentRoot().  $this->SITEMAP_PATH);
            $file->putContents($out);

            return true;

        }else{
            ShowError(Loc::getMessage('ROMANOVV_SITEMAP_FOLDER_EMPTY'));
            return false;
        }
    }

    private function getPathFolder()
    {
        return Option::get(ADMIN_MODULE_NAME, 'path_folder');

    }

    private function getAllowExt()
    {
        return Option::get(ADMIN_MODULE_NAME, 'allow_ext');

    }
    private function getPriority($date)
    {
        if(($date + 604800) > time()){
            return '1';
        }else{
            return '0.5';
        }

    }


}