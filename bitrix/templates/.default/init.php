<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$asset = \Bitrix\Main\Page\Asset::getInstance();

$asset->addString('<link href="'. DEFAULT_TEMPLATE_PATH.'"/assets/img/favicon.png" rel="icon">',
false, \Bitrix\Main\Page\AssetLocation::BEFORE_CSS);
$asset->addString('<link href="'. DEFAULT_TEMPLATE_PATH.'"/assets/img/apple-touch-icon.png" rel="icon">',
    false, \Bitrix\Main\Page\AssetLocation::BEFORE_CSS);

$asset->addString('<link rel="stylesheet" href="'.DEFAULT_TEMPLATE_PATH.'/assets/css/main.css" />', true, \Bitrix\Main\Page\AssetLocation::AFTER_CSS);
$asset->addCss(DEFAULT_TEMPLATE_PATH."/assets/vendor/bootstrap/css/bootstrap.min.css", true, \Bitrix\Main\Page\AssetLocation::BEFORE_CSS);
$asset->addCss(DEFAULT_TEMPLATE_PATH."/assets/vendor/bootstrap-icons/bootstrap-icons.css", true, \Bitrix\Main\Page\AssetLocation::BEFORE_CSS);
$asset->addCss(DEFAULT_TEMPLATE_PATH."/assets/vendor/aos/aos.css", true, \Bitrix\Main\Page\AssetLocation::BEFORE_CSS);

//$asset->addCss(DEFAULT_TEMPLATE_PATH."/assets/css/main.css", true, \Bitrix\Main\Page\AssetLocation::BEFORE_CSS);

$asset->addJs(DEFAULT_TEMPLATE_PATH."/assets/vendor/bootstrap/js/bootstrap.bundle.min.js");
$asset->addJs(DEFAULT_TEMPLATE_PATH."/assets/vendor/aos/aos.js");

$asset->addJs(DEFAULT_TEMPLATE_PATH."/assets/js/main.js");