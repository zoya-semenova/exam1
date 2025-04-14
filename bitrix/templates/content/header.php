<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/templates/.default/header.php");
?>

		<!-- Conten Page Section -->
		<section class="content-page section">

			<div class="container">
				<div class="row gy-5">

                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_TEMPLATE_PATH . "/include/sidebar.php",
                            "AREA_FILE_RECURSIVE" => "N",
                            "EDIT_MODE" => "html",
                        ),
                        false,
                        Array('HIDE_ICONS' => 'Y')
                    );?>

					<div class="col-lg-8 ps-lg-5">

						<!-- Content Page Title -->
						<div class="page-content-title">
							<div class="position-relative">
								<h1><?$APPLICATION->ShowTitle();?></h1>
								<p><?$APPLICATION->ShowProperty('page_text_under_title');?></p>
								<nav class="breadcrumbs">
                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:breadcrumb",
                                        "",
                                        array(
                                            "START_FROM" => "0",
                                            "PATH" => "",
                                            "SITE_ID" => "-"
                                        ),
                                        false,
                                        Array('HIDE_ICONS' => 'Y')
                                    );?>
								</nav>
							</div>
						</div>
						<!-- End Content Page Title -->

						<!-- CONTENT -->
