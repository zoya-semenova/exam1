<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//phpinfo();
//$result = mail('zoya.semenova132@yandex.ru','Testing 1 2 3','This is a test.');
echo '<hr>Result was: ' . ( $result === FALSE ? 'FALSE' : 'TRUE') . $result;
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>