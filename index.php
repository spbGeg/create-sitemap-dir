<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Главная');
use Bitrix\Main\Config\Option;
Option::set('romanovv.contact', 'create_elements', false);
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