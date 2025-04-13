<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="mb-5">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"vertical_multilevel",
	array(
		"ROOT_MENU_TYPE" => "left",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "3",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_SELECTED_ITEMS" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"MENU_THEME" => "site"
	),
	false,
	array(
		"HIDE_ICONS" => "N"
	)
);?>

	<?$APPLICATION->IncludeComponent("bitrix:search.title", "bootstrap_v4", array(
			"NUM_CATEGORIES" => "1",
			"TOP_COUNT" => "5",
			"CHECK_DATES" => "N",
			"SHOW_OTHERS" => "N",
			"PAGE" => SITE_DIR."catalog/",
			"CATEGORY_0_TITLE" => "Товары" ,
			"CATEGORY_0" => array(
				0 => "iblock_catalog",
			),
			"CATEGORY_0_iblock_catalog" => array(
				0 => "all",
			),
			"CATEGORY_OTHERS_TITLE" => "Прочее",
			"SHOW_INPUT" => "Y",
			"INPUT_ID" => "title-search-input",
			"CONTAINER_ID" => "search",
			"PRICE_CODE" => array(
				0 => "BASE",
			),
			"SHOW_PREVIEW" => "Y",
			"PREVIEW_WIDTH" => "75",
			"PREVIEW_HEIGHT" => "75",
			"CONVERT_CURRENCY" => "Y"
		),
		false
	);?>
</div>

<div class="mb-5">
	<h3>Мы в соцсетях</h3>
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => SITE_DIR."include/socnet_sidebar.php",
			"AREA_FILE_RECURSIVE" => "N",
			"EDIT_MODE" => "html",
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
</div>

<div class="mb-5 d-block d-sm-none">
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => SITE_DIR."include/sender.php",
			"AREA_FILE_RECURSIVE" => "N",
			"EDIT_MODE" => "html",
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
</div>

<div class="mb-5">
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => SITE_DIR."include/about.php",
			"AREA_FILE_RECURSIVE" => "N",
			"EDIT_MODE" => "html",
		),
		false,
		Array('HIDE_ICONS' => 'N')
	);?>
</div>

<div class="mb-5">
	<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/twitter.php",
		"AREA_FILE_RECURSIVE" => "N",
		"EDIT_MODE" => "html",
		"COMPONENT_TEMPLATE" => ".default",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => ""
	),
	false,
	array(
		"HIDE_ICONS" => "N"
	)
);?>
</div>

<div class="mb-5">
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => SITE_DIR."include/info.php",
			"AREA_FILE_RECURSIVE" => "N",
			"EDIT_MODE" => "html",
		),
		false,
		Array('HIDE_ICONS' => 'N')
	);?>
</div>