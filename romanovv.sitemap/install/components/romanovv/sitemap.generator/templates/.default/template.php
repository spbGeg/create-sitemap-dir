<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arResult */
/** @global CMain $APPLICATION */
$APPLICATION->SetTitle('Создание карты сайта для заданной директории');
?>

<div class="adm-gen-sitmap-wrapper">
    <div class="adm-gen-sitmap-table">
        <form method="post" action="/bitrix/admin/romanovv_sitemap_generate.php">
            <?
            echo bitrix_sessid_post();
            ?>
            <table class="adm-gen-sitmap-table">
                <tr>
                    <td width="40%">
                        <label for="generate-sitemap">Путь до папки с изображениями:</label>
                    </td>
                    <td width="60%">
                        <? if($arResult['PATH_FOLDER']) {?>
                            <span class="adm-gen-sitmap-path exist"><?=$arResult['PATH_FOLDER']?></span>
                        <? }else{ ?>
                            <span class="adm-gen-sitmap-path not-exist">
                        <?=GetMessage('ROMANOVV_SITEMAP_PATH_NOT_EXIST')?>
                        <a  href="/bitrix/admin/settings.php?lang=ru&mid=<?=ADMIN_MODULE_NAME?>&mid_menu=1">
                            <?=GetMessage('ROMANOVV_SITEMAP_SETTINGS')?>
                        </a></span>
                        <? } ?>
                    </td>
                </tr>
            </table>
            <input class="adm-btn-save btn-generate-sitemap "
                    type="submit"
                    name="generate-sitemap"
                    title="<?=getMessage('ROMANOVV_SITEMAP_GEN_START_DESC') ?>"
                    value="<?=getMessage('ROMANOVV_SITEMAP_GEN_START') ?>"
                    <?=(empty($arResult['PATH_FOLDER'])) ? 'disabled' : '' ?>
            >


        </form>
    </div>
</div>
