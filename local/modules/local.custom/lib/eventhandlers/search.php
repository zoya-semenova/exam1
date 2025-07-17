<?php

namespace Local\Custom\EventHandlers;

use Bitrix\Main\Loader;
use Bitrix\Main\Mail\Event;
use CIBlockElement;
use CUser;

class Search {

    protected static $reviews = [];
    protected static $authors = [];
    protected static $disallow = false;

    protected static function getClasses() {
        if (self::$disallow) {
            return;
        }
        self::$disallow = true;

        Loader::IncludeModule("iblock");
        $res = CIBlockElement::GetList(
            [],
            [
                "IBLOCK_ID" => 13,
                "ACTIVE" => "Y",
                "!PROPERTY_AUTHOR" => false,
            ],
            false,
            false,
            [
                "ID",
                "PROPERTY_AUTHOR",
            ]
        );
        static::$reviews = [];
        while ($row = $res->GetNext())
        {//echo "<pre>";print_r($row);echo "</pre>";exit;
            static::$reviews[$row['ID']]['AUTHOR'] = $row['PROPERTY_AUTHOR_VALUE'];
        }

        $obEnum = new \CUserFieldEnum;
        $rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => 43));
        $enum = array();
        while($arEnum = $rsEnum->Fetch())
        {
            $enum[$arEnum["ID"]] = $arEnum["VALUE"];
        }
//print_r(static::$reviews);
        $arFilter = array("ID" => implode('|', array_column( static::$reviews, 'AUTHOR')));
//print_r($arFilter);
        $arParams["SELECT"] = array("ID", "UF_USER_CLASS");
        $rsRes = CUser::GetList($by,$desc,$arFilter,$arParams);
        static::$authors = [];
        while ($arRes = $rsRes->Fetch()) {//echo "<pre>";print_r($arRes);exit;
            static::$authors[$arRes['ID']]['CLASS'] = $enum[$arRes['UF_USER_CLASS']];
        }
    }
    // создаем обработчик события "BeforeIndex"
    static function BeforeIndexHandler(&$arFields)
    {
        static::getClasses();

        if($arFields["MODULE_ID"] == "iblock" && $arFields["PARAM2"] == 13)
        {
                $arFields["TITLE"] .= " ". static::$authors[static::$reviews[$arFields["ITEM_ID"]]['AUTHOR']]['CLASS'];  // Добавим свойство в конец заголовка индексируемого элемента
        }
        return $arFields; // вернём изменения
    }

}