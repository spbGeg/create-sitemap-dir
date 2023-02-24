<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
    <div class="map-contact__container container" >
        <div class="map-contact__elements">
            <div class="map-contact__item"
                 data-name="Офис 1"
                 data-city="Санкт-Петербург"
                 data-phone="79111984156"
                 data-email="sdfffdd@email.ru"
                 data-coords="54.83, 37.11">
            </div>
            <div class="map-contact__item"
                 data-name="Офис 2"
                 data-city="Москва"
                 data-phone="79111984813156"
                 data-coords="48.83, 34.11"
                 data-email="sdd@efsfds.ru">
            </div>
        </div>
        <div id="map" class="map-contact__map js-yandex-map js-map"></div>
    </div>
</div>


