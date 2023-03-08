<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
/** @global CMain $APPLICATION */
$APPLICATION->SetTitle('Главная');
use Bitrix\Main\Config\Option;
//Option::set('romanovv.contact', 'create_elements', false);
?>
    <div class="page">
        <section id="promo" class="promo  section offset-header">
            <div class="container text-center">
                <h2 class="title">Главная страница</h2>
                <?
                use Recoil\ReferenceKernel\ReferenceKernel;

                function multiply($a, $b)
                {
                    yield; // force PHP to parse this function as a generator
                    return $a * $b;

                }

                $myRes = ReferenceKernel::start(function () {
                    $result = yield multiply(2, 3);

                    return $result;
                });

                echo $myRes;

                ?>


            </div><!--//container-->

        </section><!--//promo-->
    </div>
<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>