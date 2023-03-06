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

                $deferred = new React\Promise\Deferred();

                $deferred->promise()
                    ->then(function ($x) {

                        return $x + 1;

                    })
                    ->then(function ($x){
                        echo 'x= ' . $x;
                        if($x == 2){
                            throw new \Exception('x= 2!!!');
                        }
                    })
                    ->otherwise(function (\Exception $x) {
                        // Propagate the rejection
                        echo 'Reject ' . $x->getMessage();
                    });
                $deferred->resolve(1);


                ?>


            </div><!--//container-->

        </section><!--//promo-->
    </div>
<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>