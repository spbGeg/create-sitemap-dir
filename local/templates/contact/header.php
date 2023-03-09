<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @global CMain $APPLICATION */
/** @global CUser $USER */

use Bitrix\Main\Page\Asset;

?>
<!doctype html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><? $APPLICATION->ShowTitle() ?></title>
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH . '/img/'?>favicon.ico">
    <? $APPLICATION->ShowHead();?>

   <? // CSS
    Asset::getInstance()->addCss('/local/sources/plugins/bootstrap/css/bootstrap.min.css');
    Asset::getInstance()->addCss('/local/sources/plugins/font-awesome/css/font-awesome.min.css');
    Asset::getInstance()->addCss('/local/sources/plugins/prism/prism.min.css');

   //JS
   Asset::getInstance()->addJs('/local/sources/plugins/jquery-1.11.3.min.js');
   Asset::getInstance()->addJs('/local/sources/plugins/jquery-scrollTo/jquery.scrollTo.js');
   Asset::getInstance()->addJs('/local/sources/plugins/bootstrap/js/bootstrap.js');
   Asset::getInstance()->addJs('/local/sources/plugins/prism/prism.js');
   Asset::getInstance()->addJs('/local/sources/js/main.js');
    ?>
</head>


<body data-spy="scroll">
<? $APPLICATION->ShowPanel(); ?>

<!-- ******HEADER****** -->
<header id="header" class="header">
    <div class="container">
        <span class="logo pull-left">
            <a class="logo-title" href="/">mySite</a>
        </span><!--//logo-->
        <nav id="main-nav" class="main-nav navbar-right" role="navigation">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button><!--//nav-toggle-->
            </div><!--//navbar-header-->
            <div class="navbar-collapse collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active nav-item sr-only"><a class="scrollto" href="#">На главную</a></li>
                    <li class="nav-item"><a class="scrollto" href="#">О нас</a></li>
                    <li class="nav-item"><a class="scrollto" href="#">Продукция</a></li>
                    <li class="nav-item"><a class="scrollto" href="#">Документация</a></li>
                    <li class="nav-item last"><a  href="/contacts/">Контакты</a></li>
                </ul><!--//nav-->
            </div><!--//navabr-collapse-->
        </nav><!--//main-nav-->
    </div>
</header><!--//header-->
<div class="page">
