<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */


$APPLICATION->SetTitle('Контакты');
?>

    <!-- ******ABOUT****** -->
    <section  class="about section">
        <div class="container">
            <h1 class="title text-center">Контакты</h1>
            <p class="intro text-center">Выберите на карте подходящий офис</p>
            <div class="row">
                <div class="col-12 ">
                    <? $APPLICATION->IncludeComponent("romanovv:contacts.map", "", array(), false); ?>
                </div>
            </div><!--//row-->
        </div><!--//container-->
    </section><!--//about-->

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>