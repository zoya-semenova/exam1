<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var CBitrixComponentTemplate $this */
/** @var array $arResult */

\Bitrix\Main\Mail\EventMessageThemeCompiler::includeComponent(
	"bitrix:catalog.show.products.mail",
	"aspro_lite_products_block",
	array(
		"LIST_ITEM_ID" => $arResult['ITEMS'],
		"CATALOG_PAGE" => $arParams['CATALOG_PAGE'],
		"SHOW_CATALOG" => $arParams['SHOW_CATALOG'],
		"TITLE" => $arParams['TITLE'],
		"NOTE" => $arParams['NOTE'],
		"SHOW_BUTTON" => $arParams['SHOW_BUTTON'],
		"BUTTON_TITLE" => $arParams['BUTTON_TITLE'],
		"BUTTON_LINK" => $arParams['BUTTON_LINK'],
		"SITE_ID" => $arParams['SITE_ID'],
		"SITE_ADDRESS" => $arParams['SITE_ADDRESS'],
		"BASE_COLOR" => $arParams['BASE_COLOR'],
		"PAGE_ELEMENT_COUNT" => $arParams['PAGE_ELEMENT_COUNT'],
		"FILTER_PRICE_CODE" => $arParams['FILTER_PRICE_CODE'],
	)
);