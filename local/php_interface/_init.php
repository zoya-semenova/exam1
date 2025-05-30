<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Mail\Event;
use Bitrix\Main\Type\DateTime as BitrixDateTime;

if (!defined('IBLOCK_REVIEWS_ID'))
{
    define('IBLOCK_REVIEWS_ID', 13);
}

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler('iblock', 'OnBeforeIBlockElementAdd', 'OnBeforeIBlockElementUpdate');
$eventManager->addEventHandler('iblock', 'OnBeforeIBlockElementUpdate', 'OnBeforeIBlockElementUpdate');
$eventManager->addEventHandler('iblock', 'OnAfterIBlockElementUpdate', 'OnAfterIBlockElementUpdate');

global $author;
function OnBeforeIBlockElementUpdate(&$arFields)
{
    global $APPLICATION, $author;
    if ($arFields['IBLOCK_ID'] !== IBLOCK_REVIEWS_ID) {
        return;
    }

    if ($arFields['PREVIEW_TEXT']) {
        $APPLICATION->ThrowException('fffffffffff', []);
        return false;
    }

    $author = [];
    $props = CIBlockElement::GetProperty(IBLOCK_REVIEWS_ID, $arFields['ID'], '', '',
         ['CODE' => 'ddd']);
    if ($prop = $props->Fetch()) {
        //echo "<pre>";print_r($prop);echo "</pre>";
        $author = ['ID' => $prop['ID'], 'VALUE_ID' => $prop['PROPERTY_VALUE_ID'], 'VALUE' => $prop['VALUE']];
    }
    //exit;
    //echo "<pre>";print_r($arFields);echo "</pre>";exit;
}
function OnAfterIBlockElementUpdate(&$arFields)
{
    global $APPLICATION, $author;

    /*
    echo "<pre>";
    print_r($author);
    print_r($arFields);echo "</pre>";


    //exit;

    $props = CIBlockElement::GetProperty(IBLOCK_REVIEWS_ID, $arFields['ID'], '', '',
        ['CODE' => 'ddd']);
    while ($prop = $props->Fetch()) {
        echo "<pre>";print_r($prop);echo "</pre>";
    }
    exit;
    */

    if ($author['VALUE'] != $arFields['PROPERTY_VALUES'][$author['ID']][$author['PROPERTY_VALUE_ID']]['VALUE']) {
        CEventLog::Add([
            'SEVERITY' => 'INFO',
            'AUDIT_TYPE_ID' => 'ex2_590',
            'MODULE_ID' => '',
            'ITEM_ID' => $arFields['ID'],
            'DESCRIPTION' => "В рецензии ".$arFields['ID']." изменился автор 
            с ".$author['VALUE']." на". $arFields['PROPERTY_VALUES'][$author['ID']][$author['PROPERTY_VALUE_ID']]['VALUE'],
        ]);
    }
    //echo "<pre>";print_r($arFields['PROPERTY_VALUES'][$author['ID']][$author['PROPERTY_VALUE_ID']], 'VALUE');
    //echo "</pre>";exit;

}

$eventManager->addEventHandler('main', 'OnBeforeUserUpdate', 'OnBeforeUserUpdate');
$eventManager->addEventHandler('main', 'OnAfterUserUpdate', 'OnAfterUserUpdate');

global $class;
function OnBeforeUserUpdate(&$arFields)
{
    global $class;

    $arFilter = array("ID" => $arFields['ID']);
    $arParams["SELECT"] = array("UF_USER_CLASS");
    $arRes = CUser::GetList($by,$desc,$arFilter,$arParams);
    if ($arRes = $arRes->Fetch()) {//echo "<pre>";print_r($arRes);exit;
        $class = $arRes['UF_USER_CLASS'];
    }

    //echo "<pre>";print_r($arFields);exit;
}

function OnAfterUserUpdate(&$arFields)
{
    global $class;

    if ($arFields['UF_USER_CLASS'] != $class) {
        $obEnum = new \CUserFieldEnum;
        $rsEnum = $obEnum->GetList(array(), array("ID" => [$arFields['UF_USER_CLASS'], $class]));
        $enum = array();
        while($arEnum = $rsEnum->Fetch())
        {
            $enum[$arEnum["ID"]] = $arEnum["VALUE"];
        }

        Event::send([
            'EVENT_NAME' => 'EX2_AUTHOR_INFO',
            'LID' => 's1',
            'C_FIELDS' => [
                'OLD_USER_CLASS' => $enum[$class],
                'NEW_USER_CLASS' => $enum[$arFields['UF_USER_CLASS']],
            ]
        ]);
    }


    //echo "<pre>";print_r($enum);exit;
}

function Agent_ex_610($lastTimeExec = ""): string
{
    \Bitrix\Main\Loader::includeModule('iblock');

    $result = CIblockElement::GetList(
        ['ID' => 'ASC'],
        [
            'IBLOCK_ID' => IBLOCK_REVIEWS_ID,
            "DATE_MODIFY_FROM" => $lastTimeExec ?: (new BitrixDateTime())->add("-1 day"),
        ],
        false,
        false,
        ['ID']
    );

    $count = $result->Fetch()['CNT'];

    if ($count > 0)
    {
        CEventLog::Add([
            'SEVERITY' => 'INFO',
            'AUDIT_TYPE_ID' => 'ex2_610',
            'MODULE_ID' => '',
            'DESCRIPTION' => "Изменилось рецензий: $count",
        ]);
    }

    return "Agent_ex_610(\"" . (new BitrixDateTime())->toString() . "\");";
}

\Bitrix\Main\EventManager::getInstance()->addEventHandler(

    'main',

    //'OnBeforeEventSend',
    'OnBeforeEventAdd',

    'onBeforeAdd'

);





    function onBeforeAdd(&$event, &$lid, &$arFields)

    {


     //   echo "<pre>";print_r($arFields);exit;

        $arFields['STATUS'] = '111';

        return $arFields;
    }

$eventManager->addEventHandler('main', 'OnBuildGlobalMenu', 'OnBuildGlobalMenu');

function OnBuildGlobalMenu(&$arFields)
{
    //echo "<pre>";print_r($arFields);exit;
}