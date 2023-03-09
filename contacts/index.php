<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */

$APPLICATION->SetTitle('Контакты');
//check site template
$error = '';
if (SITE_TEMPLATE_ID !== 'contact') {
    $error = GetMessage('ROMANOVV_SET_TMPL_CONTACTS') . SITE_TEMPLATE_ID;
}
?>

    <!-- ******CONTACTS****** -->
    <section  class="contacts section">
        <div class="container">
            <h1 class="title text-center">Контакты</h1>
            <p class="intro text-center">Выберите на карте подходящий офис</p>
            <p style="color:#d41818"><?=$error?></p>
            <div class="row">

                <div class="col-12 ">
                    <? $APPLICATION->IncludeComponent("romanovv:contacts.map", "", array(), false); ?>
                </div>
            </div><!--//row-->
        </div><!--//container-->
    </section><!--//contacts-->

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>