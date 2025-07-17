<?php

namespace Local\Custom\EventHandlers;

use CUser;
use Bitrix\Main\Mail\Event;

class Main {

    static function OnBuildGlobalMenu(&$arFields, &$aModuleMenu)
    {
        global $USER;
/*
        echo "<pre>";print_r($arFields);
        print_r($aModuleMenu);
        print_r($USER);
        exit;
*/


        $globalMenu = [];
        foreach($arFields as $key => $arField) {
            if ($key == 'global_menu_content') {
                $globalMenu['global_menu_content'] = $arField;
            }
        }
        $globalMenu['global_menu_ex2'] = [

                'menu_id' => 'ex2',
                'text' => 'Быстрый доступ',
    'title' => 'Быстрый доступ',
    'url' => 'index.php?lang=ru',
    'sort' => 50,
            'items_id' => 'global_menu_ex2',
    'items' => [
        Array
        (
            "url" => "https://test1/",
            "title" => "ссылка1",
            "text" => "ссылка1",
            "page_icon" => "clouds_page_icon",
            "items_id" => "menu_ex2_link_1",
            "items" => array()
        ),
        Array
        (
            "url" => "https://test1/",
            "title" => "ссылка2",
            "text" => "ссылка2",
            "page_icon" => "clouds_page_icon",
            "items_id" => "menu_ex2_link_2",
            "items" => array()
        )
    ]
        ];
      //  $arFields = $globalMenu;

        $moduleMenu = [];
        foreach ($aModuleMenu as $key => $arMenu) {
            if ($arMenu['parent_menu'] == 'global_menu_content') {
                $moduleMenu[$key] = $arMenu;
            }
        }
     //   $aModuleMenu = $moduleMenu;
/*
        echo "<pre>";print_r($arFields);
        print_r($aModuleMenu);
        exit;
*/
    }

    static function OnBeforeUserUpdate(&$arFields)
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

    static function OnAfterUserUpdate(&$arFields)
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


    static function onBeforeAdd(&$event, &$lid, &$arFields)

    {


        //   echo "<pre>";print_r($arFields);exit;

        $arFields['CLASS'] = '111';

        return $arFields;
    }

}