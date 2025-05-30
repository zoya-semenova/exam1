<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/*
 * Здесь размещается код, выполняемый каждый раз при подключении этого модуля
 */

require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/constants.php";

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler('iblock', 'OnBeforeIBlockElementAdd', 'OnBeforeIBlockElementUpdate');
$eventManager->addEventHandler('iblock', 'OnBeforeIBlockElementUpdate', 'OnBeforeIBlockElementUpdate');
$eventManager->addEventHandler('iblock', 'OnAfterIBlockElementUpdate', 'OnAfterIBlockElementUpdate');


$eventManager->addEventHandler('main', 'OnBuildGlobalMenu', [
    'Local\Custom\EventHandlers\Main',
    'OnBuildGlobalMenu'
]);


