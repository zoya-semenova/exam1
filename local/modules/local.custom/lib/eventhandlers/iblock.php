<?
namespace Local\Custom\EventHandlers;

use Bitrix\Main\Loader;
use CIBlockElement;
use CEventLog;

class Iblock
{
    protected static $author = [];

    static function OnBeforeIBlockElementUpdate(&$arFields)
    {
        Loader::includeModule('iblock');
        global $APPLICATION;
        if ($arFields['IBLOCK_ID'] !== IBLOCK_REVIEWS_ID) {
            return;
        }

        if ($arFields['PREVIEW_TEXT']) {
            $APPLICATION->ThrowException('fffffffffff', []);
            return false;
        }

        static::$author = [];
        $props = CIBlockElement::GetProperty(IBLOCK_REVIEWS_ID, $arFields['ID'], '', '',
            ['CODE' => 'AUTHOR']);
        if ($prop = $props->Fetch()) {
            //echo "<pre>";print_r($prop);echo "</pre>";
            static::$author = ['ID' => $prop['ID'], 'VALUE_ID' => $prop['PROPERTY_VALUE_ID'], 'VALUE' => $prop['VALUE']];
        }
        //exit;
        //echo "<pre>";print_r($arFields);echo "</pre>";exit;
    }
    static function OnAfterIBlockElementUpdate(&$arFields)
    {
        Loader::includeModule('iblock');
        global $APPLICATION;

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

        if (static::$author['VALUE'] != $arFields['PROPERTY_VALUES'][static::$author['ID']][static::$author['VALUE_ID']]['VALUE']) {
            CEventLog::Add([
                'SEVERITY' => 'INFO',
                'AUDIT_TYPE_ID' => 'ex2_590',
                'MODULE_ID' => '',
                'ITEM_ID' => $arFields['ID'],
                'DESCRIPTION' => "В рецензии ".$arFields['ID']." изменился автор 
            с ".static::$author['VALUE']." на". $arFields['PROPERTY_VALUES'][static::$author['ID']][static::$author['VALUE_ID']]['VALUE'],
            ]);
        }
        //echo "<pre>";print_r($arFields['PROPERTY_VALUES'][$author['ID']][$author['PROPERTY_VALUE_ID']], 'VALUE');
        //echo "</pre>";exit;

    }

}