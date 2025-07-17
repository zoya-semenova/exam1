<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/*
 * Здесь размещается код, выполняемый каждый раз при подключении этого модуля
 */

require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/constants.php";

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler('iblock', 'OnBeforeIBlockElementAdd',
    ['Local\Custom\EventHandlers\Iblock',
    'OnBeforeIBlockElementUpdate'
    ]
    );
$eventManager->addEventHandler('iblock', 'OnBeforeIBlockElementUpdate',
    ['Local\Custom\EventHandlers\Iblock',
        'OnBeforeIBlockElementUpdate']);
$eventManager->addEventHandler('iblock', 'OnAfterIBlockElementUpdate',
    ['Local\Custom\EventHandlers\Iblock',
        'OnAfterIBlockElementUpdate']);


$eventManager->addEventHandler('main', 'OnBuildGlobalMenu', [
    'Local\Custom\EventHandlers\Main',
    'OnBuildGlobalMenu'
]);


$eventManager->addEventHandler('main', 'OnBeforeUserUpdate',
    ['Local\Custom\EventHandlers\Main',
        'OnBeforeUserUpdate']);
$eventManager->addEventHandler('main', 'OnAfterUserUpdate',
    ['Local\Custom\EventHandlers\Main',
        'OnAfterUserUpdate']);

\Bitrix\Main\EventManager::getInstance()->addEventHandler(

    'main',

    //'OnBeforeEventSend',
    'OnBeforeEventAdd',

    ['Local\Custom\EventHandlers\Main',
        'onBeforeAdd']

);


// регистрируем обработчик
AddEventHandler("search", "BeforeIndex",
    [
        'Local\Custom\EventHandlers\Search',
        "BeforeIndexHandler"
    ]);
