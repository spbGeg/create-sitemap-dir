<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

//use VadimRomanov\Contact;
use VadimRomanov\Contact;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

?>
<div class="map-contact">
    <div class="map-contact__msg <?= ($arResult['CREATE_ELEMENTS']['ERROR']) ? ' error' : '' ?>">
        <?= $arResult['CREATE_ELEMENTS']['MSG'] . ' ' . $arResult['CREATE_ELEMENTS']['ERROR'] ?>
    </div>
    <div class="map-contact__container container">
        <? if(!empty($arResult['ITEMS'])) {?>
        <div class="map-contact__elements">
            <? foreach ($arResult['ITEMS'] as $item) { ?>
                <div class="map-contact__item"
                     data-name="<?= $item['NAME'] ?>"
                     data-city="<?= $item['CITY'] ?>"
                     data-phone="<?= $item['PHONE'] ?>"
                     data-email="<?= $item['EMAIL'] ?>"
                     data-coords="<?= $item['COORDS'] ?>">
                </div>
            <? } ?>
        </div>
        <? } ?>
        <div id="map" class="map-contact__map js-yandex-map js-map"></div>
    </div>
</div>


<?

?>