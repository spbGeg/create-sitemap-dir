<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 */

?>
<div class="map-contact">
    <div class="map-contact__msg"><?= $arResult['CREATE_ELEMENTS']['MSG'] ?></div>
    <div class="map-contact__msg error"><?= ($arResult['ERROR']) ? 'Ошибка: ' . $arResult['ERROR'] . '!' : ''?></div>
    <div class="map-contact__msg error"><?= $arResult['RAND'];?></div>
    <div class="map-contact__msg error">Количество <?= $arResult['COUNT_TOTAL'];?></div>
    <div class="map-contact__container container">
        <? if (!empty($arResult['ITEMS'])) { ?>
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
            <div id="map" class="map-contact__map js-yandex-map js-map"></div>
        <? }else{ ?>
            <div class="no-elements">Контакты не созданы</div>
        <? } ?>

    </div>
</div>