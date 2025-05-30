<?php

namespace Local\Custom\EventHandlers;

class Main {

    static function OnBuildGlobalMenu(&$arFields)
    {
        echo "<pre>";print_r($arFields);exit;
    }

}