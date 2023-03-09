<?php defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

defined('ADMIN_MODULE_NAME') or define('ADMIN_MODULE_NAME', 'romanovv.sitemap');

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Bitrix\Main\IO;



/** @global CMain $APPLICATION */
/** @global CUser $USER */


if (!$USER->isAdmin()) {
    $APPLICATION->authForm(Loc::getMessage('ROMANOVV_SITEMAP_NEED_AUTH'));
    exit();
}
Loc::loadMessages(__FILE__);
$mid = \RomanovvSitemap::MODULE_ID;
\Bitrix\Main\Loader::includeModule($mid);

$app = Application::getInstance();
$context = $app->getContext();
$request = $context->getRequest();

$pathFolder = Option::get(ADMIN_MODULE_NAME, 'path_folder');
$pathSitemap = Option::get(ADMIN_MODULE_NAME, 'path_sitemap') ?? \RomanovvSitemap::PATH_SITEMAP;

$tabControl = new CAdminTabControl('tabControl', [[
    'DIV' => 'edit1',
    'TAB' => Loc::getMessage('MAIN_TAB_SET'),
    'TITLE' => Loc::getMessage('MAIN_TAB_TITLE_SET'),
]]);


if ($request->isPost() && check_bitrix_sessid()) {
    if (!empty($request->getPost('save'))) {
        $error = false;

        //save folder path
        $newPathFolder = $request->getPost('generate-sitemap') ?? '';

        if($newPathFolder){
            $dir = new IO\Directory(Application::getDocumentRoot() . $newPathFolder);
            $isExist = $dir->isExists();
            if($isExist){
                $pathFolder = $newPathFolder;
                Option::set(ADMIN_MODULE_NAME, 'path_folder', $pathFolder);

            }else{
                $error = true;
                CAdminMessage::showMessage([
                    'MESSAGE' => GetMessage('ROMANOVV_SITEMAP_PATH_FOLDER_WRONG'),
                    'TYPE' => 'ERROR',
                ]);
            }
        }else{
            $error = true;
            CAdminMessage::showMessage([
                'MESSAGE' => GetMessage('ROMANOVV_SITEMAP_NO_SET_PATH_FOLDER'),
                'TYPE' => 'ERROR',
            ]);
        }
        //save name sitemap
        $newNameSitemap = $request->getPost('name-sitemap');


        if($newNameSitemap !== $pathSitemap) {
            if(!empty($newNameSitemap)){
                $pathSitemap = $newNameSitemap;
                Option::set(ADMIN_MODULE_NAME, 'path_sitemap', $pathSitemap);
            }else{
                $error = true;
                CAdminMessage::showMessage([
                    'MESSAGE' => GetMessage('ROMANOVV_SITEMAP_NO_SET_NAME_SITEMAP'),
                    'TYPE' => 'ERROR',
                ]);
            }

        }
        //save allow ext
        $newAllowExt = $request->getPost('allow-ext') ?? '';

        if($newAllowExt){
            Option::set(ADMIN_MODULE_NAME, 'allow_ext', $newAllowExt);
        }else{
            $error = true;
            CAdminMessage::showMessage([
                'MESSAGE' => GetMessage('ROMANOVV_SITEMAP_EXT_NOT_SET'),
                'TYPE' => 'ERROR',
            ]);
        }

        if(!$error){
            CAdminMessage::showMessage([
                'MESSAGE' => GetMessage('ROMANOVV_SITEMAP_SETTING_SAVE'),
                'TYPE' => 'OK',
            ]);
        }

    }else if(!empty($request->getPost('restore'))){
        Option::set(ADMIN_MODULE_NAME, 'path_folder', '');
        $pathFolder = '';

        $pathSitemap =  \RomanovvSitemap::PATH_SITEMAP;
        Option::set(ADMIN_MODULE_NAME, 'path_sitemap', $pathSitemap);

        $newAllowExt = '';
        Option::set(ADMIN_MODULE_NAME, 'allow_ext', $newAllowExt);


        CAdminMessage::showMessage([
            'MESSAGE' => GetMessage('ROMANOVV_SITEMAP_SETTING_DEFAULT_SET'),
            'TYPE' => 'OK',
        ]);
    }
}

$tabControl->begin();
?>

<form method="post"
      action="<?= sprintf('%s?mid=%s&lang=%s', $request->getRequestedPage(), \urlencode($mid), LANGUAGE_ID) ?>">
    <?
    echo bitrix_sessid_post();
    $tabControl->beginNextTab();
    ?>
    <tr>
        <td width="40%">
            <label for="generate-sitemap"><?=GetMessage("ROMANOVV_SITEMAP_PATH_FOLDER")?>:</label>
        </td>
        <td width="60%">
            <input
                    type="text"
                    size="50"
                    name="generate-sitemap"
                    placeholder="/upload/my-img/"
                    value="<?=$pathFolder?>"
            >
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="name-sitemap"><?=GetMessage("ROMANOVV_SITEMAP_NAME_SITEMAP")?>:</label>
        </td>
        <td width="60%">
            <input
                    type="text"
                    size="50"
                    name="name-sitemap"
                    placeholder="<?=$pathSitemap?>"
                    value="<?=$pathSitemap?>"
            >
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="name-sitemap"><?=GetMessage("ROMANOVV_SITEMAP_ALLOW_EXT")?>:</label>
        </td>
        <td width="60%">
            <input
                    type="text"
                    size="50"
                    name="allow-ext"
                    placeholder="jpg, png, svg"
                    value="<?=$newAllowExt?>"
            >
        </td>
    </tr>




    <?
    $tabControl->buttons();
    ?>

    <input type="submit"
           name="save"
           value="<?= Loc::getMessage('MAIN_SAVE') ?>"
           title="<?= Loc::getMessage('MAIN_OPT_SAVE_TITLE') ?>"
           class="adm-btn-save"
    >
    <input type="submit"
           name="restore"
           value="<?= Loc::getMessage('MAIN_HINT_RESTORE_DEFAULTS') ?>"
           title="<?= Loc::getMessage('MAIN_HINT_RESTORE_DEFAULTS') ?>"
           class=""
    >
    <?
    $tabControl->end();
    ?>

</form>