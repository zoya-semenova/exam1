<?

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\AssetLocation;

$asset = \Bitrix\Main\Page\Asset::getInstance();

//$asset->addString(DEFAULT_TEMPLATE_PATH."/assets/img/favicon.png", false, AssetLocation::BEFORE_CSS);
//$asset->addString(DEFAULT_TEMPLATE_PATH."/assets/img/apple-touch-icon.png", false, AssetLocation::BEFORE_CSS);

$asset->addCss(DEFAULT_TEMPLATE_PATH."/assets/vendor/bootstrap/css/bootstrap.min.css");
$asset->addCss(DEFAULT_TEMPLATE_PATH."/assets/vendor/bootstrap-icons/bootstrap-icons.css");
$asset->addCss(DEFAULT_TEMPLATE_PATH."/assets/vendor/aos/aos.css");

$asset->addCss(DEFAULT_TEMPLATE_PATH."/assets/css/main.css");

$asset->addJs(DEFAULT_TEMPLATE_PATH."/assets/vendor/bootstrap/js/bootstrap.bundle.min.js");
$asset->addJs(DEFAULT_TEMPLATE_PATH."/assets/vendor/aos/aos.js");

$asset->addJs(DEFAULT_TEMPLATE_PATH."/assets/js/main.js");

