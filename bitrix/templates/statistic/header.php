<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @global  CMain $APPLICATION */

//IncludeTemplateLangFile(__FILE__);
use Bitrix\Main\Localization\Loc;

define('ST_TEMPLATE_PATH', "/bitrix/templates/statistic");

?>
<? //echo DEFAULT_TEMPLATE_PATH;exit;?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?=ST_TEMPLATE_PATH?>/assets/img/favicon.png" rel="icon">

  <!-- Vendor CSS Files -->
  <link href="<?=ST_TEMPLATE_PATH?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?=ST_TEMPLATE_PATH?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?=ST_TEMPLATE_PATH?>/assets/css/style.css" rel="stylesheet">
    <?$APPLICATION->ShowHead();?>
</head>

<body>
<div id="panel">
    <?//$APPLICATION->ShowPanel();?>
</div>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Статистика</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <?if ($GLOBALS["USER"]->IsAuthorized()):?>
          <?$APPLICATION->IncludeComponent(
              "bitrix:system.auth.form",
              "profile",
              Array(
                  "PROFILE_URL" => "",
                  "SHOW_ERRORS" => "N"
              ),
              "",
              array(
                  "HIDE_ICONS" => "Y"
              )
          );?>
        <?endif;?>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <?$APPLICATION->IncludeComponent(
            "bitrix:menu",
            "vertical_multilevel",
            array(
                "ROOT_MENU_TYPE" => "st_first",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_TIME" => "0",
                "MENU_CACHE_USE_GROUPS" => "N",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "MAX_LEVEL" => "2",
                "CHILD_MENU_TYPE" => "st_second",
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

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle mb-4">
      <h1>Пустая страница</h1>
    </div><!-- End Page Title -->

    <section class="section">

      