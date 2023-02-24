<? if( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
	die();
}
/** @global CMain $APPLICATION */
/** @global CUser $USER */

include(S_P_LAYOUT.'/header.php');

use Bitrix\Main\Page\Asset;


?>
	<div class="main-layout">
	<!-- HEADER :: START-->
	<div class="preloader d-none">
		<div class="preloader__loader">
			<img src="/personal/img/preloader.gif" alt=""/>
		</div>
	</div>
	<header class="header-redesign">
        <? /*  temporary hidden, show when be multidomain func ?>
        <div class="header-redesign__topbar">
            <div class="header-redesign__topbar-container">
                <div class="header-redesign__town-container js-open-select-city">
                    <div class="header-redesign__town-icon"></div>
                    <div class="header-redesign__town-value">Москва</div>
                </div>
                <div class="header-redesign__topbar-contacts">
                    <div class="header-redesign__topbar-contacts-container">
                        <div class="header-redesign__topbar-contacts-label">Бесплатно по РФ:</div>
                        <a class="header-redesign__topbar-contacts-value value nowrap" href="tel:88006000565">8 (800) 600-05-65</a>
                    </div>
                    <a class="header-redesign__topbar-contacts-caller link" data-fancybox="" href="#modal-request">Заказать звонок</a>
                </div>
            </div>
        </div>
        <?*/?>
		<div class="header-redesign__container container">
			<div class="header-redesign__row">
				<div class="header-redesign__btn-menu">
					<div class="hamburger"><span class="line"></span><span class="line"></span><span class="line"></span></div>
				</div>
				<a class="header-redesign__logo" href="/">
					<img src="<?=P_G_V2_FRONTEND?>/dist/assets/images/logo.svg" alt="">
				</a>
				<? $APPLICATION->IncludeComponent("bitrix:menu", "top", array(
					"ROOT_MENU_TYPE" => "top_v2",
					"MAX_LEVEL" => "4",
					"CHILD_MENU_TYPE" => "sub",
					"USE_EXT" => "Y",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "Y",
					"MENU_CACHE_TYPE" => "N",
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => "",
					"COMPONENT_TEMPLATE" => "left",
				)); ?>
				<a class="header-redesign__btn btn btn--primary btn--small" href="/calculator/">Расcчитать дом</a>
            <? /*  temporary hidden, show when be multidomain func ?>
				<div class="module-contacts header-redesign__contacts">
					<div class="module-contacts__label"><?=$obDomain->phoneIsFreeText(); ?></div>
					<? $phone = $obDomain->getFiledWithCheck(["BRANCH_OFFICE" => "OG_DEFAULT_PHONE"]);?>
					<a class="module-contacts__value nowrap" href="<?=$obDomain->getPhoneLink($phone)?>"><?=$obDomain->getPhoneText($phone)?></a>
					<a class="module-contacts__link" href="#modal-request" data-fancybox="">Заказать звонок</a>
				</div>
                <? */ ?>

                <? // START temporary show, must hidden when be multidomain func ?>
                <div class="module-contacts header-redesign__contacts">
                    <div class="module-contacts__label">Бесплатно по РФ:</div>
                    <a class="module-contacts__value nowrap" href="tel:88002343207">8 (800) 23-43-207</a>
                    <a class="module-contacts__link" href="#modal-request" data-fancybox="">Заказать звонок</a>
                </div>
                <? // END temporary show, must hidden when be multidomain func ?>

				<a class="header-redesign__search" href="/search/">
					<svg class="svg-icon">
						<use href="<?=P_G_V2_FRONTEND?>/dist/assets/icons/sprite.svg#icon-search"></use>
					</svg>
				</a>
				<div class="header-redesign__separator">
				</div>

				<? if( ! $USER->IsAuthorized()){?>

				<a class="header-redesign__signup" href="#" onclick="openPopup('js-q-login-popup'); return false;">
					<svg class="svg-icon">
						<use href="<?=P_G_V2_FRONTEND?>/dist/assets/icons/sprite.svg#icon-sign"></use>
					</svg>
					<span>Войти</span>
				</a>
				<?}else{?>
				<a class="header-redesign__notifications has-message" href="/personal/notifications/">
					<svg class="svg-icon">
						<use href="<?=P_G_V2_FRONTEND?>/dist/assets/icons/sprite.svg#icon-bell"></use>
					</svg>
				</a>
				<div class="header-redesign__user">
					<div class="header-redesign__user-icon-link">
						<svg class="svg-icon">
							<use href="<?=P_G_V2_FRONTEND?>/dist/assets/icons/sprite.svg#icon-user"></use>
						</svg>
					</div>
					<div class="header-redesign__user-link">
						<div class="header-redesign__user-name">
							<a href="/personal/" class="fio" data-desctop="<?=$profileName?>" data-mobile="<?=$mobileName?>"><?=$profileName?></a>
						</div>
						<svg width="14" height="8" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="m1 1 6 6 6-6" stroke="#54555A" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<div class="header-auth__hidden">
							<nav class="header-auth__menu">
								<a href="/personal/notifications/" class="header-auth__menu-item _bell">
									<span class="header-auth__menu-icon _bell"></span>
									<div class="header-auth__menu-text">Уведомления</div>
								</a>
								<a href="/personal/favorites/" class="header-auth__menu-item">
									<span class="header-auth__menu-icon _fav"></span>
									<div class="header-auth__menu-text">Избранное</div>
								</a>
								<!-- <a href="/personal/info/" class="header-auth__menu-item">
									<span class="header-auth__menu-icon _info"></span>
									<div class="header-auth__menu-text">Инфо</div>
								</a> -->
								<a href="/personal/settings/" class="header-auth__menu-item">
									<span class="header-auth__menu-icon _settings"></span>
									<div class="header-auth__menu-text">Настройки</div>
								</a>
								<a href="/?logout=yes" class="header-auth__menu-item _logout">
									<span class="header-auth__menu-icon _logout"></span>
									<div class="header-auth__menu-text">Выйти</div>
								</a>
							</nav>
							<div class="header-auth__bg js-hide-submenu-mobile"></div>
						</div>
					</div>

				</div>

				<?}?>

			</div>
		</div>
	</header>


	<!-- HEADER :: END-->
	<!-- what should be changed with every pjax-->
<div class="page <? if(strpos($curDir, "/personal/") !== false) : ?> _personal-dir<? endif ?>">

<div class="page__content<? if($curDir != "/") : ?> not_home<? endif ?>">

<? /*if($USER->IsAuthorized()):?>


<!-- BEGIN SECTION :: nav-->


<section class="nav"></section>


<!-- NAV :: BEGIN-->


<div js-teleport data-teleport-to="mobile-nav" data-teleport-condition="&lt;788">


	<nav class="navigation">


		<div class="container">


			<div class="navigation__grid">


				<div class="navigation__left"><a href="/club/profile/">Мои данные</a><a href="/club/portfolio/">Мои объекты</a><a href="/club/orders/">Заказы</a></div>


				<div class="navigation__middle"><a href="/club/learning/">Обучение</a><a href="/club/history/">Начисление и списание</a><a href="/club/gifts/">Призы</a></div>


				


				<?


				$arCartData = include(S_P_INTERFACE.'/cart.php');


				?>


				<?$newID = \X\Helpers\Html::newID();?><!--#<?=$newID?>-->


				<script id="minicart_data"  type="application/json">


					{


						"data": <?=json_encode($arCartData['vue']['minicart'])?>


					}


				</script>


				<script id="minicart_tmpl"  type="x-template">


					<div id="minicart" class="navigation__right">


						<a href="/club/cart/"><img src="<?=P_IMAGES?>/shop.svg" alt=""><span class="cif">{{ num_gifts }}</span><span>{{ word_gifts }}</span></a>


						<a class="no-barbar" href="/?logout=yes"><span>Выйти</span><img src="<?=P_IMAGES?>/logout.svg" alt=""></a>


					</div>


				</script>


				<div widget="vue" id="minicart" class="navigation__right"></div>


			</div>


		</div>


	</nav>


</div>


<!-- NAV :: END-->


<!-- END SECTION :: nav-->


<?endif;*/ ?>