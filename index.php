<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
/** @global CMain $APPLICATION */
$APPLICATION->SetTitle('Главная');
use Bitrix\Main\Config\Option;
//brake options it needed for test created elements
Option::set('romanovv.contact', 'create_elements', '');
?>
    <div class="page">
        <section id="promo" class="promo  section offset-header">
            <div class="container text-center">
                <h2 class="title">Главная страница</h2>
            </div><!--//container-->

        </section><!--//promo-->
    </div>
<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>