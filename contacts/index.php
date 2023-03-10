<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

use Bitrix\Main\Page\Asset;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
Asset::getInstance()->addJs('/local/sources/plugins/jquery-1.11.3.min.js');
Asset::getInstance()->addJs('/local/sources/js/map.js');

$APPLICATION->SetTitle('Контакты');
//check site template
$error = '';
if (SITE_TEMPLATE_ID !== 'contact') {
    $error = GetMessage('ROMANOVV_SET_TMPL_CONTACTS') . SITE_TEMPLATE_ID;
}
?>
    <!-- ******CONTACTS****** -->
    <section class="contacts section">
        <div class="container">
            <h1 class="title text-center">Контакты</h1>
            <p class="intro text-center">Выберите на карте подходящий офис</p>
            <p style="color:#d41818"><?= $error ?></p>
            <div class="row">

                <div class="col-12 ">

                    <div class="map-contact">
                        <div class="loader">
                            <svg viewBox="0 0 120 120" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <circle class="load one" cx="60" cy="60" r="40" />
                                <circle class="load two" cx="60" cy="60" r="40" />
                                <circle class="load three" cx="60" cy="60" r="40" />
                                <g>
                                    <circle class="point one" cx="45" cy="70" r="5" />
                                    <circle class="point two" cx="60" cy="70" r="5" />
                                    <circle class="point three" cx="75" cy="70" r="5" />
                                </g>
                            </svg>
                        </div>
                        <div class="map-contact__msg error"></div>
                        <div class="map-contact__container container">
                            <div id="map" class="map-contact__map js-yandex-map js-map"></div>
                        </div>
                    </div>
                </div>
            </div><!--//row-->
        </div><!--//container-->
    </section><!--//contacts-->

    <script>
        $(document).ready(function () {
            let wrap = $('.map-contact');
            if (wrap != null) {
                var $app = new JSMapContacts(wrap);
            }
        });
    </script>
<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>