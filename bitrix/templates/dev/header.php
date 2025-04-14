<?
/**
 * @global $APPLICATION
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/templates/.default/header.php");
?>

<? if (Application::getInstance()->getContext()->getRequest()->getRequestedPageDirectory() != "/"):?>

<!-- Page Title -->
		<div class="page-title dark-background">
			<div class="container position-relative">
				<h1><?$APPLICATION->ShowTitle(false); ?></h1>
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
		</div><!-- End Page Title -->

		<!-- Starter Section Section -->
<?endif;?>
		