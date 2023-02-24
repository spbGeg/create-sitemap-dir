<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


/** @global CMain $APPLICATION */
/*  temporary hidden, show when be multidomain func
/** @global $obDomain */

?>
</div>
<!--.page__content-->

<!-- FOOTER :: START-->
<footer class="footer-redesign">
	<div class="footer-redesign__container container">
		<div class="footer-redesign__top-row">
			<a class="footer-redesign__logo" href="#">
				<img src="<?=P_G_V2_FRONTEND?>/dist/assets/images/logo-white.svg" alt="">
			</a>

            <? /*  temporary hidden, show when be multidomain func ?>
			<div class="module-contacts footer-redesign__contacts">
				<div class="module-contacts__label"><?=$obDomain->phoneIsFreeText(); ?></div>
				<? $phone = $obDomain->getFiledWithCheck(["BRANCH_OFFICE" => "OG_DEFAULT_PHONE"]);?>
				<a class="module-contacts__value nowrap" href="<?=$obDomain->getPhoneLink($phone)?>"><?=$obDomain->getPhoneText($phone)?></a>
			</div>
			<div class="module-contacts footer-redesign__contacts">
				
				<? if($timeWork = $obDomain->getFiledWithCheck(['BRANCH_OFFICE'=> 'OG_WORKING_HOURS'])){
					foreach($timeWork as $itemTime){?>
				<div class="module-contacts__label"><?=$itemTime?></div>
				<? }}?>


				<div class="module-contacts__value"><?=$obDomain->getFiledWithCheck(['BRANCH_OFFICE'=> 'OG_ADDRESS']) ?></div>
			</div>
            */?>

            <? // START temporary show, must hidden when be multidomain func ?>
            <div class="module-contacts footer-redesign__contacts">
                <div class="module-contacts__label">Бесплатно по РФ
                </div>
                <a class="module-contacts__value nowrap" href="tel:+78002343207">
                    8 800 23 43 207				</a>
            </div>
            <div class="module-contacts footer-redesign__contacts">
                <div class="module-contacts__label">Ежедневно с 8:00 до 20:00
                </div>
                <div class="module-contacts__value">Москва, ул. Гиляровского, д, 47, стр. 5
                </div>
            </div>
            <? // END temporary show, must hidden when be multidomain func ?>

			<div class="footer-redesign__top-buttons">
				<a class="footer-redesign__btn btn btn--primary" href="/calculator/">Расcчитать дом</a>
				<a class="footer-redesign__btn btn btn--white-line" href="https://shop.tn.ru/?utm_source=domtnru&utm_medium=organic&utm_campaign=refferal">Интернет-магазин</a>
			</div>
		</div>
		<div class="footer-menu">
            <div class="social-icon-container">
                <div class="footer-icon-youtube social">
                    <a href="https://www.youtube.com/watch?v=SFPKHf7mXN4&amp;list=PLEJVlrtqBJD6WoWV3J688_c_ZwU8LFjY-" class=" footer-redesign__link"></a>
                </div>
                <div class="footer-icon-vk social">
                    <a href="https://vk.com/public211330056" class=" footer-redesign__link"></a>
                </div>
            </div>
		<? $APPLICATION->IncludeComponent("bitrix:menu", "bottom", array(
			"ROOT_MENU_TYPE" => "bottom",
			"MAX_LEVEL" => "2",
			"CHILD_MENU_TYPE" => "sub",
			"USE_EXT" => "Y",
			"DELAY" => "N",
			"ALLOW_MULTI_SELECT" => "Y",
			"MENU_CACHE_TYPE" => "N",
			"MENU_CACHE_TIME" => "3600",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_CACHE_GET_VARS" => "",
		)); ?>
		</div>

		<div class="footer-redesign__bottom-row">
			<div class="footer-redesign__bottom-col">
				<p class="footer-redesign__copyright">© <?=date('Y')?> DOM TECHNONICOL
				</p>
				<ul class="footer-redesign__bottom-links">
					<li>
						<a class="footer-redesign__bottom-link" href="/legal/">Политика обработки персональных данных</a>
					</li>
					<li>
						<a class="footer-redesign__bottom-link" href="/legal/">Пользовательское соглашение</a>
					</li>
					<li>
						<a class="footer-redesign__bottom-link" href="/legal/">Согласие на обработку персональных данных</a>
					</li>
				</ul>
			</div>
			<div class="footer-redesign__bottom-col">
				<a class="footer-redesign__ux" href="https://uxart.ru/" target="_blank"><span>Интерфейсы от </span>
					<svg width="64" height="13" viewBox="0 0 64 13" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M37.0567 9.29468H30.1314L28.6398 12.6286H27.2725L32.9548 0.148621H34.2511L39.9334 12.6286H38.5483L37.0567 9.29468ZM36.5772 8.22496L33.594 1.52142L30.6108 8.22496H36.5772Z" fill="white"/>
						<path d="M58.0099 1.28965H53.6416V0.148621H63.6922V1.28965H59.3239V12.6286H58.0099V1.28965Z" fill="white"/>
						<path d="M50.4777 12.6286L47.6366 8.61719C47.3169 8.65285 46.9855 8.67068 46.6421 8.67068H43.3038V12.6286H41.9897V0.148621H46.6421C48.2285 0.148621 49.4715 0.528963 50.3712 1.28965C51.2709 2.05033 51.7207 3.09628 51.7207 4.42748C51.7207 5.40211 51.4721 6.22816 50.9749 6.90565C50.4896 7.57125 49.7911 8.05262 48.8796 8.34976L51.9161 12.6286H50.4777ZM46.6066 7.54748C47.8378 7.54748 48.7789 7.27411 49.43 6.72736C50.0811 6.18062 50.4067 5.41399 50.4067 4.42748C50.4067 3.41719 50.0811 2.64462 49.43 2.10976C48.7789 1.56302 47.8378 1.28965 46.6066 1.28965H43.3038V7.54748H46.6066Z" fill="white"/>
						<path d="M22.0162 12.6286L19.0152 8.29628L16.0675 12.6286H12.7646L17.3638 6.28165L12.9955 0.148621H16.2628L19.1217 4.19571L21.9274 0.148621H25.0349L20.7021 6.17468L25.3368 12.6286H22.0162Z" fill="white"/>
						<path d="M5.88635 12.8426C4.11063 12.8426 2.72558 12.3493 1.73118 11.3628C0.748609 10.3763 0.257324 8.96782 0.257324 7.13742V0.148621H3.134V7.03045C3.134 9.26496 4.05735 10.3822 5.90411 10.3822C6.80381 10.3822 7.49042 10.1148 7.96394 9.57994C8.43747 9.03319 8.67423 8.18336 8.67423 7.03045V0.148621H11.5154V7.13742C11.5154 8.96782 11.0182 10.3763 10.0238 11.3628C9.04122 12.3493 7.66207 12.8426 5.88635 12.8426Z" fill="white"/>
					</svg>
				</a>
			</div>
		</div>
	</div>
</footer>




<!-- Mobile menu-->
<? $APPLICATION->IncludeComponent("bitrix:menu", "mobile", array(
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

<!-- FOOTER :: END-->
<!-- COOKIE ALERT :: START-->
<? if(empty($_COOKIE["cookiesAccept"])) : ?>
	<div class="g-v2 cookie-alert b-privacy-popup--open">
		<div class="cookie-alert__icon">
			<img src="/local/sources/images/cookie-icon.svg" alt="cookie icon">
		</div>
		<div class="cookie-alert__text">
			<p>Наш сайт использует cookie файлы для хранения данных.<br> Продолжая использовать сайт, вы даете свое согласие на работы с этими файлами</p>
		</div>
		<span class="cookie-alert__btn btn btn--primary" href="#" data-cookies="cookiesAccept">Принять и закрыть</span>
	</div>
<? endif ?>
<!-- COOKIE ALERT :: END-->
<? if($last_event and $last_event != $_COOKIE['last_event']) : ?>
	<div class="b-privacy-popup _events" data-last-event="">
		<div class="q-inner">
			<div class="b-privacy-popup__text">
				<div class="b-privacy-popup__text-inner">
					<span class="b-privacy-popup__text-icon" style="background-image: url(<?=P_PICTURES?>/calendar.svg)"></span> Ознакомьтесь со списком мероприятий.
					<a class="b-privacy-popup__link" href="/blog/events/"><span>Перейти</span></a>
				</div>
				<span class="b-privacy-popup__btn" data-cookies="last_event" data-accept="<?=$last_event?>"></span>
			</div>
		</div>
	</div>
<? endif ?>


</div>
<!--.page-->
</div>
<!-- Modals-->
<? $APPLICATION->IncludeComponent( // send order pupup
	"bitrix:main.include", "", array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => P_CONTENT."/sendorder_popup.php",
		"PAGE_ID" => 'projects',
	)
); ?>
<? include(S_P_INCLUDES . '/content/action_popup3.php'); ?>

<?php /*  temporary hidden, show when be multidomain func
<? include(S_P_INCLUDES . '/content/popup-your-city.php'); ?>
<? include(S_P_INCLUDES . '/content/popup-select-city.php'); ?>
*/?>



<? include(S_P_LAYOUT . '/footer.php'); ?>

<? include(S_P_INCLUDES . '/content/action_steam.php'); ?>

<script>
	var jivo_onIntroduction = function() {
		fbq('track', 'Lead');
	}
</script>