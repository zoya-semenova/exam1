<?php
const NEED_AUTH = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
exit;
?>
<?php
$APPLICATION->SetTitle("Авторизация");
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:system.auth.form",
    "st",
    Array(
        "REGISTER_URL" => $arParams["REGISTER_URL"],
        "FORGOT_PASSWORD_URL" => $arParams["FORGOT_PASSWORD_URL"],
        "PROFILE_URL" => "",
        "SHOW_ERRORS" => "N"
    ),
    $component->__parent,
    array(
        "HIDE_ICONS" => "Y"
    )
);?>

<p>Вы зарегистрированы и успешно авторизовались.</p>

<p><a href="<?=SITE_DIR?>">Вернуться на главную страницу</a></p>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
