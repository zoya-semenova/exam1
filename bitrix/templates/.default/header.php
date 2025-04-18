<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @global  CMain $APPLICATION */

//IncludeTemplateLangFile(__FILE__);
use Bitrix\Main\Localization\Loc;

define('DEFAULT_TEMPLATE_PATH', "/bitrix/templates/.default");

include_once \Bitrix\Main\Application::getDocumentRoot()."/bitrix/templates/.default/init.php";
?>
<? //echo DEFAULT_TEMPLATE_PATH;exit;?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title><?$APPLICATION->ShowTitle();?></title>


        <?$APPLICATION->ShowHead();?>
    </head>

<body class="scrolled">
<div id="panel">
    <?$APPLICATION->ShowPanel();?>
</div>

    <header id="header" class="header d-flex align-items-center">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="/" class="logo d-flex align-items-center">
                <h1 class="sitename"><?= GetMessage('COMPANY'); ?></h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "horizontal_multilevel",
                    array(
                        "ROOT_MENU_TYPE" => "top",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "0",
                        "MENU_CACHE_USE_GROUPS" => "N",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                        "MAX_LEVEL" => "3",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "N",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "Y",
                    ),
                    false,
                    array(
                        "HIDE_ICONS" => "N"
                    )
                );?>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>



        </div>
    </header>

<main class="main">
