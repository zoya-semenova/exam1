<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?>
<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    Array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => DEFAULT_TEMPLATE_PATH."/include/main/hero.php",
        "AREA_FILE_RECURSIVE" => "N",
        "EDIT_MODE" => "html",
    ),
    false,
    Array('HIDE_ICONS' => 'Y')
);?>
<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    Array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => DEFAULT_TEMPLATE_PATH."/include/main/featured.php",
        "AREA_FILE_RECURSIVE" => "N",
        "EDIT_MODE" => "html",
    ),
    false,
    Array('HIDE_ICONS' => 'Y')
);?>
<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    Array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => DEFAULT_TEMPLATE_PATH."/include/main/about.php",
        "AREA_FILE_RECURSIVE" => "N",
        "EDIT_MODE" => "html",
    ),
    false,
    Array('HIDE_ICONS' => 'Y')
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>