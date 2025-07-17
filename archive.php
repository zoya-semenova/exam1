<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Архив");
use Bitrix\Crm\Service;
use Bitrix\Main\Loader;
use \Bitrix\Crm\Service\Container;
use \Bitrix\Crm\Item;

header('Content-Type: text/html; charset=UFT-8');
mb_internal_encoding('UTF-8');
global $DB;
?>

    <link id="style" href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- STYLE CSS -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/dark-style.css" rel="stylesheet" />
    <link href="assets/css/transparent-style.css" rel="stylesheet">
    <link href="assets/css/skin-modes.css" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="assets/css/icons.css" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/colors/color1.css" />

    <style>

        #file-datatable {
            display: none !important;
        }


        #file-datatable_length {
            display: none;
        }

        #file-datatable_paginate {
            display: none;
        }

        #file-datatable_info {
            display: none;
        }

        #file-datatable_filter input {
            display: none;
        }

        .col-md-6 label {
            float: left;
        }


        .buttons-copy {
            display: none !important;
        }
        .buttons-pdf {
            display: none !important;
        }
        .buttons-collection {
            display: none !important;
        }

        #responsive-datatable_filter input {
            border: 1px solid #4000FF;
            width: 450px;
            float: left;
        }


        table {
            font-size: 14px;
        }

        .select2 {
            width: 100% !important;
        }

        td {
            padding-left: 0px !important;
        }
        tr td > span {
            padding-left: 11.68px !important;
        }
        tr td > b {
            padding-left: 11.68px !important;
        }

        th {
            padding-right: 5px !important;
        }
        i {
            border: solid black;
            border-width: 0 3px 3px 0;
            display: inline-block;
            cursor: pointer;
            padding: 3px;
            margin-left: 10px;
        }

        .right {
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
        }

        .left {
            transform: rotate(135deg);
            -webkit-transform: rotate(135deg);
        }

        .up {
            transform: rotate(-135deg);
            -webkit-transform: rotate(-135deg);
        }

        .down {
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
        }

        .dt-buttons {
            z-index: 4;
            margin-left: 350px !important;
        }
    </style>


    <script>

        function showFilter() {
            var x = document.getElementById('filterBlock');

            if ((x.style.display=='none') || (x.style.display == null)) {
                x.style.display = 'flex';abkmn
            }
            else {
                x.style.display = 'none';
            }
        }
    </script>

<?

/*
function getUniqueItem($itemList) {
  $uniqueHotels = array();
  foreach($itemList as $item) {
    $niddle = $item['ID'];
    if(array_key_exists($niddle, $uniqueHotels)) continue;
    $uniqueHotels[$niddle] = $item;
  }
  return $uniqueHotels;
}

*/
function getUniqueItem($array) {
    $key = 'ID';
    $tmp = $key_array = array();
    $i = 0;

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $tmp[$i] = $val;
        }
        $i++;
    }
    return $tmp;
}


function getReq($companyList) {

    $entityRequisite = new \Bitrix\Crm\EntityRequisite;
    $rsRequisite = $entityRequisite->getList([
        "select"=>array("*"),
        "filter"=>array("ENTITY_ID"=> $companyList,"ENTITY_TYPE_ID"=>CCrmOwnerType::Company),
        "order"=>array("SORT"=>"desc","ID"=>"desc")

    ]);
    $arRequisite =  $rsRequisite->fetchAll();

#$res = array_merge($arContactRequisite, $arRequisite);
    return $arRequisite;
}


function getContact($contact_list) {
    $arFilter = array('CHECK_PERMISSIONS' => 'N', 'ID' => $contact_list);
    $arSelect = array('ID', 'NAME', 'LAST_NAME', 'SECOND_NAME');
    $cList = \CCrmContact::GetList(array(), $arFilter, $arSelect);
    $res = array();
    while ($itemC = $cList->Fetch()) {
        $res[] = $itemC;
    }
    return $res;
}


function getCompany($company_list) {
    $arFilter = array('CHECK_PERMISSIONS' => 'N', 'ID' => $company_list);
    $arSelect = array('ID', 'TITLE');
    $cList = \CCrmCompany::GetList(array(), $arFilter, $arSelect);
    $res = array();
    while ($itemC = $cList->Fetch()) {
        $res[] = $itemC;
    }
    return $res;
}


function getStage($stage) {
    if ($stage=='DT158_13:NEW') {
        #$res = 'Черновик';
    }
    if ($stage=='DT158_13:CLIENT') {
        #$res = 'На согласовании';
    }
    if ($stage=='DT158_13:UC_IGDAKS') {
        #$res = 'Согласование завершено';
    }

    if ($stage=='DT158_13:UC_4O846B') {
        $res = 'Исполняется';
    }

    if ($stage=='DT158_13:FAIL') {
        $res = 'Не действует';
    }

    if ($stage=='DT156_17:FAIL') {
        $res = 'Не действует';
    }


    if ($stage=='DT158_13:UC_31J9LL') {
        #$res = 'На подписании у контрагента';
    }

    if ($stage=='DT158_13:SUCCESS') {
        $res = 'Действует';
    }
    if ($stage=='DT156_17:UC_AZQKL3') {
        $res = 'Исполняется';
    }
    if ($stage=='DT156_17:SUCCESS') {
        $res = 'Действует';
    }
    if ($stage=='DT158_23:SUCCESS') {
        $res = 'Действует';
    }
    if ($stage=='DT158_23:FAIL') {
        $res = 'Действует';
    }
    return $res;
}


function getTypeS($type) {
    $type = (int)$type;
    if ($type==1804) {
        $res = 'NDA';
    }
    if ($type==1800) {
        $res = 'LSA';
    }
    if ($type==1801) {
        $res = 'Договор расх.';
    }
    if ($type==1853) {
        $res = 'Прочее';
    }
    if ($type==1859) {
        $res = 'Бумажная копия';
    }
    if ($type==1860) {
        $res = 'Электронная (ЭДО)';
    }

    if ($type==1923) {
        $res = 'Legal Tech и автоматизация процессов';
    }
    if ($type==1784) {
        $res = 'M&A (А. Ахуба)';
    }
    if ($type==1785) {
        $res = 'M&A (И. Макаров)';
    }
    if ($type==1786) {
        $res = 'Middle East Desk';
    }
    if ($type==1799) {
        $res = 'Административная поддержка бизнеса';
    }
    if ($type==1945) {
        $res = 'Банкротство (А. Боломатов)';
    }
    if ($type==1778) {
        $res = 'Банкротство (В. Ефремов)';
    }
    if ($type==1777) {
        $res = 'Банкротство (Д. Базаров)';
    }
    if ($type==1779) {
        $res = 'Банкротство (С. Лисин)';
    }
    if ($type==1780) {
        $res = 'Интеллектуальная собственность и технологии';
    }
    if ($type==1781) {
        $res = 'Коммерческое право';
    }
    if ($type==1782) {
        $res = 'Конкурентное право';
    }
    if ($type==1787) {
        $res = 'Международное налоговое планирование (А. Голиков)';
    }
    if ($type==1788) {
        $res = 'Налоговое консультирование и споры (А. Голиков)';
    }
    if ($type==1789) {
        $res = 'Налоговое консультирование и споры (П. Кондуков)';
    }
    if ($type==1890) {
        $res = 'Недвижимость и строительство';
    }
    if ($type==1797) {
        $res = 'Прочая деятельность';
    }
    if ($type==1796) {
        $res = 'Расчеты и клиринг';
    }
    if ($type==1790) {
        $res = 'Санкционное право - С. Гландин';
    }
    if ($type==1791) {
        $res = 'Семейное право';
    }
    if ($type==1974) {
        $res = 'Семейное право (Штоян)';
    }
    if ($type==1792) {
        $res = 'Таможенное право';
    }
    if ($type==1798) {
        $res = 'Трансграничные споры';
    }
    if ($type==1793) {
        $res = 'Транспорт и финансирование активов';
    }
    if ($type==1794) {
        $res = 'Трудовое право';
    }

    if ($type==1854) {
        $res = 'ДC';
    }
    if ($type==2137) {
        $res = 'Рынки капитала';
    }
    if ($type==2138) {
        $res = 'Международные споры и санкции';
    }
    if ($type==2145) {
        $res = 'MENA 24';
    }
    if ($type==1855) {
        $res = 'Поручение';
    }
    if ($type==1856) {
        $res = 'Прочее';
    }
    if ($type==1859) {
        $res = 'Бумажная копия';
    }
    if ($type==1860) {
        $res = 'Электронная (ЭДО)';
    }
    if ($type==2210) {
        $res = 'Практика промышленности';
    }
    if ($type==1795) {
        $res = 'Уголовно-правовая защита бизнеса (А. Логинов)';
    }
    if ($type==2373) {
        $res = 'Уголовно-правовая защита бизнеса (Д. Саушкин)';
    }
    return trim(preg_replace( "#(^(&nbsp;|\s)+|(&nbsp;|\s)+$)#", "", $res));
}
$arDataDeal = array();
$arFilter = array();
$arDealList = array();
$arCompany = array();
$arContactD = array();
$mycompanyList = array();
$arCFO = array();
$arFilterData = array();
$arFilterPril = array();
if ((int)$_SESSION['select']>0) {
    $select = $_SESSION['select'];
}
else {
    $select = 4;
    $_SESSION['select'] = 4;
}
if (isset($_POST['selectAll'])) {
    $select = 1;
    $_SESSION['select'] = 1;
}

if (isset($_POST['selectDogovor'])) {
    $select = 2;
    $_SESSION['select'] = 2;
}

if (isset($_POST['selectPril'])) {
    $select = 3;
    $_SESSION['select'] = 3;
}

if (isset($_POST['selectNoIer'])) {
    $select = 4;
    $_SESSION['select'] = 4;
}
?>
<? if ($select<>4) { ?>
    <style>
        .dt-buttons {
            display: none !important;
        }
    </style>
<? } ?>
<?

if (!empty($_POST['kAgent'])) {
    if ((strpos($_POST['kAgent'], 'COMPANY_'))>-1) {
        $arFilter['COMPANY_ID'] = " = ".mb_substr($_POST['kAgent'], 8, strlen($_POST['kAgent']));
        if ($select==4) {
            $arFilterPril['COMPANY_ID'] = " = ".mb_substr($_POST['kAgent'], 8, strlen($_POST['kAgent']));
        }
    }
    else {

        $arFilter['CONTACT_ID'] = " = ".mb_substr($_POST['kAgent'], 8, strlen($_POST['kAgent']));
        if ($select==4) {
            $arFilterPril['CONTACT_ID'] = " = ".mb_substr($_POST['kAgent'], 8, strlen($_POST['kAgent']));
        }
    }
    $arFilterData = array_merge($arFilter, $arFilterData);
}

if (isset($_POST['pForm'])) {
    if ((int)$_POST['pForm']==1) {
        $arFilterData['UF_CRM_10_1696862579'] = " = 1859";
        if ($select==4) {
            $arFilterPril['UF_CRM_14_1696848691'] = " = 1859";
        }
    }
    if ((int)$_POST['pForm']==2) {
        $arFilterData['UF_CRM_10_1696862579'] = " = 1860";
        if ($select==4) {
            $arFilterPril['UF_CRM_14_1696848691'] = " = 1860";
        }
    }
}



$stageIDdata = '';
$stageIDpril = '';
if ((isset($_POST['status'])) && ((int)$_POST['status']>0)) {
    if ($_POST['status']==1) {
        $stageIDdata = "13:SUCCESS";
        if ($select==4) {
            $stageIDpril = "17:SUCCESS";
        }
    }
    if ($_POST['status']==2) {
        $stageIDdata  = "13:FAIL";
        if ($select==4) {
            $stageIDpril  = "17:FAIL";
        }
    }
}

if ((isset($_POST['kProject'])) && ((int)$_POST['kProject']>0)) {
    $arFilter['UF_CRM_10_1733853669'] = " = ".(int)$_POST['kProject'];
    $arFilterData = array_merge($arFilter, $arFilterData);
    if ($select==4) {
        $arFilterPril['UF_CRM_14_1733844404'] = " = ".$_POST['kProject'];
    }
}

if ( (isset($_POST['kDoc'])) && (!empty($_POST['kDoc']))) {

    if ( ($_POST['kDoc']<1854) && (is_int((int)$_POST['kDoc'])) ) {
        $arFilterData['UF_CRM_10_1692807563'] = " = ".(int)$_POST['kDoc'];
        if ($select==4) {
            $arFilterPril['ID'] = " = 0";
        }
    }
    if (($_POST['kDoc']>=1854) && (is_int((int)$_POST['kDoc'])) ) {
        $arFilterPril['UF_CRM_14_1696588270'] = " = ".(int)$_POST['kDoc'];

        if ($select==4) {
            $arFilterData['ID'] = "= 0";
        }

    }

    if ($_POST['kDoc']=='LSAram') {
        $arFilterData['UF_CRM_10_1692807563'] = " = 1800";
        $arFilterData['CATEGORY_ID'] = " = 13";
        if ($select==4) {
            $arFilterData['ID'] = "<> 0";
            $arFilterPril['ID'] = " = 0";
        }
    }

}
if (!empty($_POST['dateStart'])) {

    $dateStart = date('d.m.Y', strtotime($_POST['dateStart']));
    if (empty($_POST['dateStop'])) {
        $dateStop = date('d.m.Y', strtotime(now));
    }
    else {
        $dateStop = date('d.m.Y', strtotime($_POST['dateStop']));
    }
}


if ((!empty($_POST['yPerson'])) && ((int)$_POST['yPerson']>0)) {
    $arFilter['MYCOMPANY_ID'] = " = ".(int)$_POST['yPerson'];
    $arFilterData = array_merge($arFilter, $arFilterData);
    $arFilterPril['MYCOMPANY_ID'] = " = ".(int)$_POST['yPerson'];
}



foreach ($arFilterData as $it => $valDat) {
    $arFilterDataQuery .= $arFilterDataQuery." AND ".$it." ".$valDat;
}

if ($select<>3) {
    $query = 'SELECT * FROM `b_crm_dynamic_items_158` WHERE ID <> -1'.$arFilterDataQuery.' ORDER BY `ID` DESC';
    $res = $DB->Query($query);
    while ($item = $res->Fetch()) {
        if (($item['STAGE_ID']<>'DT158_13:NEW') and ($item['STAGE_ID']<>'DT158_13:UC_F7OQSY')) {
            if ($_POST['status']==1) {
                if ($item['STAGE_ID']=='DT158_13:SUCCESS') {
                    $dataItem[] = $item;
                }
            }
            elseif($_POST['status']==2) {
                if ($item['STAGE_ID']=='DT158_13:FAIL') {
                    $dataItem[] = $item;
                }
            } elseif(!empty($dateStart)) {
                if ( (strtotime($item['UF_CRM_10_1692010426'])>=strtotime($dateStart)) and (strtotime($item['UF_CRM_10_1692010426'])<=strtotime($dateStop)) ) {
                    $dataItem[] = $item;
                }
            } elseif($_POST['cfo']>0) {
                if (in_array((int)$_POST['cfo'], unserialize($item['UF_CRM_10_1696847511']))) {
                    $dataItem[] = $item;
                }
            }
            else {
                $dataItem[] = $item;
            }

        }
    }


}


$dataItem = getUniqueItem($dataItem);


foreach ($arFilterPril as $it => $valDat) {
    $arFilterPrilQuery .= $arFilterPrilQuery." AND ".$it." ".$valDat;
}


$query = "SELECT * FROM `b_crm_dynamic_items_156` WHERE ID <> -1 ".$arFilterPrilQuery." ORDER BY `ID` DESC";
$res = $DB->Query($query);
while ($item = $res->Fetch()) {
    if (($item['STAGE_ID']<>'DT156_17:NEW') and ($item['STAGE_ID']<>'DT156_17:UC_HA8Z71')) {

        if ( (!empty($dateStart)) and ($select==4) ) {
            if ( (strtotime($item['UF_CRM_14_1696848478'])>=strtotime($dateStart)) and (strtotime($item['UF_CRM_14_1696848478'])<=strtotime($dateStop)) ) {
                if  ($_POST['status']==1) {

                    if ($item['STAGE_ID']=='DT156_17:SUCCESS')  {
                        $dataItemPril[] = $item;
                    }
                } else {
                    $dataItemPril[] = $item;
                }
            }
        }  elseif( ($_POST['status']==1) && (empty($dateStart)) ) {
            if ($item['STAGE_ID']=='DT156_17:SUCCESS') {
                $dataItemPril[] = $item;
            }
        } elseif(($_POST['status']==2) && (empty($dateStart)) ) {
            if ($item['STAGE_ID']=='DT156_17:FAIL') {
                $dataItemPril[] = $item;
            }
        } elseif($_POST['cfo']>0) {
            if (in_array((int)$_POST['cfo'], unserialize($item['UF_CRM_14_1696848041']))) {
                $dataItemPril[] = $item;
            }
        } else {

            $dataItemPril[] = $item;
        }

    }


}

$dataItemPril = getUniqueItem($dataItemPril);

$iii = 0;


foreach ($dataItem as $itemCompany) {
    if ((int)$itemCompany['COMPANY_ID']>0) {
        $arCompany[] = $itemCompany['COMPANY_ID'];
    }
    if ((int)$itemCompany['MYCOMPANY_ID']>0) {
        $mycompanyList[] = (int)$itemCompany['MYCOMPANY_ID'];
    }
    if ((int)$itemCompany['CONTACT_ID']>0) {
        $arContactD[] = $itemCompany['CONTACT_ID'];
    }
    if ((int)$itemCompany['UF_CRM_10_1733853669']>0) {
        $arDealList[] = $itemCompany['UF_CRM_10_1733853669'];
    }
    foreach (unserialize($itemCompany['UF_CRM_10_1696847511']) as $itCF) {
        $arCFO[] = $itCF;
    }
}



foreach ($dataItemPril as $key) {
    if ((int)$key['COMPANY_ID']>0) {
        $arCompany[] = $key['COMPANY_ID'];
    }
    if ((int)$key['UF_CRM_14_1733844404']>0) {
        $arDealList[] = $key['UF_CRM_14_1733844404'];
    }
    if ((int)$key['CONTACT_ID']>0) {
        $arContactD[] = $key['CONTACT_ID'];
    }

}

if (count($arCFO)>0) {
    $arCFO = array_unique($arCFO);
}

if (count($arContactD)>0) {
    $arContactD = getContact(array_unique($arContactD));
}

if ($_POST['aplyFilter']>0) {
    $arCompany = $_SESSION['arCompany'];
    $arContactD = $_SESSION['arContactD'];
    $arCFO = $_SESSION['arCFO'];
}
else {
    $_SESSION['arCompany'] = $arCompany;
    $_SESSION['arContactD'] = $arContactD;
    $_SESSION['arCFO'] = $arCFO;
}

if (count($arCompany)>0) {
    $arCompany = getReq(array_unique($arCompany));

}

if (count($arDealList)>0) {
    $arDealList = array_unique($arDealList);
}






if ($_POST['aplyFilter']>0) {

    $mycompanyList = $_SESSION['mycompanyList'];
}
else {
    $mycompanyList = getCompany(array_unique($mycompanyList));
    $_SESSION['mycompanyList'] = $mycompanyList;
}


if ($_POST['aplyFilter']>0) {

    $arCFO = $_SESSION['arCFO'];
}
else {
    $_SESSION['arCFO'] = $arCFO;
}

$dealFilter = array('ID' => $arDealList);
$dealSelect = array('ID', 'TITLE');

$dealList = \CCrmDeal::GetList(array(), $dealFilter, $dealSelect);

while ($dd = $dealList->Fetch()) {
    $arDataDeal[] = $dd;
}

if ($_POST['aplyFilter']>0) {
    $arDataDeal = $_SESSION['arDataDeal'];
}
else {
    $_SESSION['arDataDeal'] = $arDataDeal;
}

?>

    <br>
    <form style="float: left; margin-right: 10px;" action="#" method="POST">
        <input type="hidden" name="selectNoIer" value="4">
        <button style="<? if ($select==4) { ?> font-weight: bold; text-decoration: underline; <? } ?> border: none; background: none">Без иерархии</button>
    </form>


    <form style="float: left; margin-right: 10px;" action="#" method="POST">
        <input type="hidden" name="selectAll" value="1">
        <button style="<? if ($select==1) { ?> font-weight: bold; text-decoration: underline; <? } ?> border: none; background: none">Все элементы с иерархией</button>
    </form>





    <a style="text-decoration: underline;" href="/archive/">Сбросить фильтр</a><br>
    <span style="cursor: pointer;" onclick="var x = document.getElementById('filterBlock');        if ((x.style.display=='none') || (x.style.display == null)) { x.style.display = 'flex';} else {x.style.display = 'none';}">Фильтры:<i class="arrow down"> </i></span>

    <form style="display: flex;" id="filterBlock" class="form-control" action="#" method="POST">
        <div class="col-sm-4">
            Выберите период (Дата От):<br><br>
            От: <input name="dateStart" class="form-control" type="date" value="<?= $_POST['dateStart'];?>"><br>
            До: <input name="dateStop" class="form-control" value="<?= $_POST['dateStop'];?>" type="date">
            <br>
            Тип документа:
            <select class="form-control" name="kDoc">
                <option value="0">Не указан</option>
                <? if (($select==1) or ($select==4)) { ?>
                    <option <? if ($_POST['kDoc']==1800) { ?> selected <? } ?> value="1800">Все LSA</option>
                    <option <? if ($_POST['kDoc']=="LSAram") { ?> selected <? } ?> value="LSAram">LSA (рамочные)</option>
                    <option <? if ($_POST['kDoc']==1804) { ?> selected <? } ?> value="1804">NDA</option>
                    <? if ($select<>4) { ?>
                        <option <? if ($_POST['kDoc']==1853) { ?> selected <? } ?> value="1853">Прочее (договоры)</option>
                    <? } ?>

                <? } ?>
                <? if ($select==4) { ?>
                    <option <? if ($_POST['kDoc']==1854) { ?> selected <? } ?> value="1854">ДС</option>
                    <option <? if ($_POST['kDoc']==1855) { ?> selected <? } ?> value="1855">Поручение</option>

                <? } ?>
            </select>
        </div>

        <div class="col-sm-4">
            <br><br>
            Контрагент:<br>
            <select class="search-select form-control js-select2"  name="kAgent">


                <option value="0">Не указан</option>
                <? foreach ($arCompany as $cmpItem) { ?>
                    <? if (($_POST['kAgent']) == "COMPANY_".$cmpItem['ENTITY_ID']) {?>
                        <option selected value="COMPANY_<?= $cmpItem['ENTITY_ID'];?>">

                            <? if (mb_strlen($cmpItem['RQ_COMPANY_NAME'])>1) {
                                echo $cmpItem['RQ_COMPANY_NAME'];
                            } else {
                                echo "ИП ".$cmpItem['RQ_NAME'];
                            }?>, <?= $cmpItem['RQ_INN'];?></option>
                    <? } ?>
                    <option value="COMPANY_<?= $cmpItem['ENTITY_ID'];?>">
                        <? if (mb_strlen($cmpItem['RQ_COMPANY_NAME'])>1) {
                            echo $cmpItem['RQ_COMPANY_NAME'];
                        } else {
                            echo "ИП ".$cmpItem['RQ_NAME'];
                        }?>, <?= $cmpItem['RQ_INN'];?>
                    </option>
                <? } ?>
                <? foreach ($arContactD as $contItem) { ?>
                    <? if (($_POST['kAgent']) == "CONTACT_".$contItem['ID']) {?>
                        <option selected value="CONTACT_<?= $contItem['ID'];?>"><?= $contItem['LAST_NAME'];?> <?= $contItem['NAME'];?> <?= $contItem['SECOND_NAME'];?></option>
                    <? } ?>
                    <option value="CONTACT_<?= $contItem['ID'];?>"><?= $contItem['LAST_NAME'];?> <?= $contItem['NAME'];?> <?= $contItem['SECOND_NAME'];?></option>
                <? } ?>
            </select><br><br>
            Проект:<br>
            <select class="search-select js-select2 form-control" name="kProject">
                <option value="0">Не указан</option>
                <? foreach ($arDataDeal as $iDeal) { ?>
                    <? if (($_POST['kProject']) == $iDeal['ID']) {?>
                        <option selected value="<?= $iDeal['ID'];?>"><?= $iDeal['TITLE'];?></option>

                    <? } ?>
                    <option value="<?= $iDeal['ID'];?>"><?= $iDeal['TITLE'];?></option>
                <? } ?>
            </select><br><br>
            ЦФО:<br>
            <select class="search-select js-select2 form-control" name="cfo">
                <option value="0">Не указан</option>
                <? foreach ($arCFO as $iCFO) { ?>
                    <? if (($_POST['cfo']) == $iCFO) {?>
                        <option selected value="<?= $iCFO;?>"><?= getTypeS($iCFO);?></option>

                    <? } ?>
                    <option value="<?= $iCFO;?>"><?= getTypeS($iCFO);?></option>
                <? } ?>
            </select><br>


        </div>
        <div class="col-sm-4">
            <br><br>
            Статус:<br>
            <select class="search-select form-control" name="status">
                <option value="0">Не указан</option>
                <option <? if ($_POST['status']==1) { ?> selected <? } ?> value="1">Действует</option>
                <option <? if ($_POST['status']==2) { ?> selected <? } ?> value="2">Не действует</option>

            </select>
            <br>
            Форма подписания:<br>
            <select class="search-select form-control" name="pForm">
                <option value="0">Не указан</option>
                <option <? if ($_POST['pForm']==1) { ?> selected <? } ?> value="1">Бумажная копия</option>
                <option <? if ($_POST['pForm']==2) { ?> selected <? } ?> value="2">Электронная (ЭДО)</option>

            </select>
            <br>
            Юр.лицо BGP:
            <select class="form-control" name="yPerson">
                <option value="0">Не выбрано</option>
                <? foreach ($mycompanyList as $myItem) { ?>
                    <? if (($_POST['yPerson']) == $myItem['ID']) {?>
                        <option selected value="<?= $myItem['ID'];?>"><?= $myItem['TITLE'];?></option>
                    <? } ?>
                    <option value="<?= $myItem['ID'];?>"><?= $myItem['TITLE'];?></option>
                <? } ?>
            </select>
            <br>
            <input type="hidden" name="aplyFilter" value="1">
            <button class="btn btn-primary">Найти</button>
        </div>
    </form>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div style="position: relateive; display: block; height: 40px;" <?php if ($select <> 1) { ?> id="file-datatable_wrapper" <? } else { ?> id="datatable" <? } ?> data-inner="<?= $select;?>" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row"><div class="row"><div class="col-sm-12">


                                    <!--
    <table <? if ($select<>1) { ?> id="file-datatable" <? } else { ?> id="datatable" <? } ?> class="table table-stripedto text-nowrap key-buttons border-bottom dataTable no-footer" role="grid" aria-describedby="file-datatable_info">
!-->


                                    <!-- Таблица для импорта !-->

                                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                        <tr role="row">

                                            <th style="display: none;" class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable"></th>
                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width:80px;">ID</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 379.094px;">Тип</th>



                                            <th class="border-bottom-0 sorting sorting_asc" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 243.578px;">Контрагент</th>

                                            <th style="display: none" class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 180.281px;">Наименование документа</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 50px;">№</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspanё="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 200.281px;">Дата От</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">Статус</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">Дата До</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">ИНН</th>


                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">Проект</th>


                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">BGP <br>Юр. лицо</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">Форма подписания</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">ЦФО</th>

                                            <th style="display: none;" class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">Владелец документа</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?
                                        foreach ($dataItemPril as  $itemPril) {
                                            if ($select==4) {
                                                $arPril[] = $itemPril;
                                            }
                                        }

                                        ?>

                                        <? if ($select !==3 ) { ?>
                                            <? foreach ($dataItem as $item) { ?>

                                                <?



                                                $dPril = array();
                                                foreach ($dataItemPril as  $itemPril) {
                                                    if ($itemPril['UF_CRM_14_1733843020']==$item['ID']) {
                                                        $dPril[] = $itemPril;
                                                    }
                                                }

                                                $dPril = getUniqueItem($dPril);
                                                ?>


                                                <tr class="odd">
                                                    <td style="display: none"></td>
                                                    <td style="padding-left: 0px; padding-right: 0px;">

     <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <? if ($select<>3) { ?>

            <?= $item['UF_CRM_10_1730819805760'];?>
        <? } ?>&nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') {
                                                                    ?>
                                                                    <br>
                                                                    <span style="display: block; margin-top: 6px;">

                <?= $dataPril['UF_CRM_14_1730820394442'];?></span>
                                                                <? } }
                                                        }?>

                                                    </td>


                                                    <td style="padding-left: 0px; padding-right: 0px;">
        <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;"><?
            if ($select<>3) {
                $r = getTypeS($item['UF_CRM_10_1692807563']);
                echo $r;
            }
            ?>      &nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {

                                                            foreach ($dPril as $dataPril) {

                                                                if ($dataPril['TITLE'] <>'') { ?> <br><b style="display: block; margin-top: 6px; "> <?= getTypeS($dataPril['UF_CRM_14_1696588270']);?> </b> <? } } } ?>
                                                    </td>


                                                    <td style="padding-left: 0px; padding-right: 0px;">
    <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <? if ($select<>3) { ?>
            <?
            $idComp = $item['COMPANY_ID'];
            if ($idComp>0) {
                foreach ($arCompany as $iComp) {
                    if ($idComp==$iComp['ENTITY_ID']) {
                        $container_company = $iComp;
                    }
                }
            } else { $container_company['RQ_COMPANY_NAME'] = ''; }
            if (!empty($container_company['RQ_COMPANY_NAME'])) {
                ?>

                <?= $container_company['RQ_COMPANY_NAME'];?>

            <? } elseif (!empty($container_company['RQ_NAME'])) { ?>ИП <?= $container_company['RQ_NAME'];?>


            <? } else { ?>
                <?
                foreach ($arContactD as $keyContact) {
                    if ($item['CONTACT_ID']==$keyContact['ID']) { ?>
                        <?
                        $fullNameTitle = $keyContact['LAST_NAME']." ".$keyContact['NAME']." ".$keyContact['SECOND_NAME'];
                        ?>

                    <?  } } ?>
                <?= $fullNameTitle ;?>
                <?
            } }?>
&nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {

                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <?
                                                                    $idComp = $dataPril['COMPANY_ID'];
                                                                    if ($idComp>0) {
                                                                        foreach ($arCompany as $iComp) {
                                                                            if ($idComp==$iComp['ENTITY_ID']) {
                                                                                $container_company = $iComp;
                                                                            }
                                                                        }
                                                                    } else { $container_company['RQ_COMPANY_NAME'] = ''; }
                                                                    ?>
                                                                    <br><span style="display: block; margin-top: 6px;"> <?

                                                                        if (!empty($container_company['RQ_COMPANY_NAME'])) {
                                                                            ?>

                                                                            <?= $container_company['RQ_COMPANY_NAME'];?>
                                                                        <? } else {
                                                                            foreach ($arContactD as $keyContact) {
                                                                                if ($dataPril['CONTACT_ID']==$keyContact['ID']) { ?>
                                                                                    <?
                                                                                    $fullNameTitle = $keyContact['LAST_NAME']." ".$keyContact['NAME']." ".$keyContact['SECOND_NAME'];
                                                                                    $fullName = $fullNameTitle;
                                                                                    ?>
                                                                                    <?= $fullName ;?>
                                                                                <? } } }?>
 </span>
                                                                <? } } }?>
                                                    </td>



                                                    <td style="display: none" >
                                                        <? if ($select<>3) { ?>
                                                            <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;"> <?= $item['TITLE'];?></span>&nbsp;
                                                        <? } ?>
                                                        <? if (($select==1) or ($select==3)) {

                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?> <br><b style="display: block; margin-top: 6px; "> <?= $dataPril['TITLE'];?> &nbsp;</b> <? } }  }?>
                                                    </td>






                                                    <td style="padding-left: 0px; padding-right: 0px;">
                                                        <? if ($select<>3) { ?>
                                                            <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
                <? $compName = $item['UF_CRM_10_1692019862058'];
                ?>
                <?= $compName ;?>
       </span>
                                                        <? } ?>
                                                        <? if (($select==1) or ($select==3)) {

                                                            foreach ($dPril as $dataPril) {

                                                                if ($dataPril['TITLE'] <>'') { ?> <br><span style="display: block; margin-top: 6px;"> <?= $dataPril['UF_CRM_14_1696848468084']; ?> </span> <? } } }?>
                                                    </td>


                                                    <td style="padding-left: 0px; padding-right: 0px;">
                                                        <? if ($select<>3) { ?>

                                                            <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <?= $item['UF_CRM_10_1692010426'];?>
   &nbsp; </span>
                                                        <? } ?>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?> <br><b style="display: block; margin-top: 6px; "> <?= $dataPril['UF_CRM_14_1696848478'];?> </b> <? } }  }?>
                                                    </td>




                                                    <td style="padding-left: 0px; padding-right: 0px;">
        <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <?= getStage($item['STAGE_ID']);?>&nbsp;
    </span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {

                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">
                <?= getStage($dataPril['STAGE_ID']);?>&nbsp;
            </span>
                                                                <? } } }?>
                                                    </td>


                                                    <td style="padding-left: 0px; padding-right: 0px;">

     <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
            <?= $item['UF_CRM_10_1692010502'];?> &nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">
                <?= $dataPril['UF_CRM_14_1696848511'];?>&nbsp;
            </span>
                                                                <? } } }?>
                                                    </td>


                                                    <td style="padding-left: 0px; padding-right: 0px;">
    <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
    <? foreach ($arCompany as $i) {
        if ($i['ENTITY_ID']==$item['COMPANY_ID']) {
            ?>


            <?= $i['RQ_INN'];?>
        <? } } ?>
    &nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">

                <? foreach ($arCompany as $i) {
                    if ($i['ENTITY_ID']==$dataPril['COMPANY_ID']) {
                        ?>


                        <?= $i['RQ_INN'];?>
                    <? } } ?>
            &nbsp;</span>
                                                                <? } } } ?>
                                                    </td>

                                                    <td style="padding-left: 0px; padding-right: 0px;">
                                                        <?
                                                        if ($select<>3) {
                                                            $cDeal = \CCrmDeal::GetById($item['UF_CRM_10_1733853669'], false);
                                                            ?> <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
    <? if (!empty($cDeal['TITLE'])) { ?>

        <? $dTmpName = $cDeal['TITLE']; ?>
        <?= $dTmpName;?>
    <? } ?> &nbsp;</span> <? } ?>

                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;"> <?
                                                                        $deal = \CCrmDeal::GetById($dataPril['UF_CRM_14_1733844404'], false);
                                                                        ?>
                                                                        <? if (!empty($deal['TITLE'])) { ?>
                                                                            <?= $deal['TITLE'];?> <? } ?>&nbsp; </span>
                                                                <? } } }?>
                                                    </td>




                                                    <td style="padding-left: 0px; padding-right: 0px;">
                                                        <?
                                                        $bgp = \CCrmCompany::GetById($item['MYCOMPANY_ID'], false);
                                                        ?>
                                                        <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">  <?= $bgp['TITLE'];?> &nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">

                <?
                $bgpPril = \CCrmCompany::GetById($dataPril['MYCOMPANY_ID'], false);
                ?>

                                                                        <?= $bgpPril['TITLE'];?>&nbsp;
            </span>
                                                                <? } } }?>
                                                    </td>






                                                    <td style="padding-left: 0px; padding-right: 0px;">

     <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <?= getTypeS($item['UF_CRM_10_1696862579']);?>&nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">
                <?= getTypeS($dataPril['UF_CRM_14_1696848691']);?>&nbsp;
            </span>
                                                                <? } } }?>
                                                    </td>

                                                    <td style="padding-left: 0px; padding-right: 0px;">
            <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
           <? if (unserialize($item['UF_CRM_10_1696847511'])>0) {
               foreach (unserialize($item['UF_CRM_10_1696847511']) as $itemEl) {
                   $lenStr = getTypeS($itemEl);
                   echo $lenStr;


               };?>
           <? } else { ?><? } ?>&nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">
                <?
                foreach (unserialize($dataPril['UF_CRM_14_1696848041']) as $itemEl) {
                    $strItem = getTypeS($itemEl);
                    echo $strItem;

                };?>&nbsp;

            </span>
                                                                <? } } } ?>
                                                    </td>



                                                    <td style="display: none;">
        <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <? foreach (unserialize($item['UF_CRM_10_1696599768']) as $itemPart) {
            $usPart = \CUser::GetById($itemPart)->Fetch(); ?>

            <?= $usPart['LAST_NAME'];?> <?= $usPart['NAME'];?> <?= $usPart['SECOND_NAME'];?>

        <? } ?>&nbsp;</span>

                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?> <br>
                                                                    <span style="display: block; font-weight: bold; width: 100%; margin-top: 6px;">

      <?
      foreach ($dataPril['UF_CRM_14_1696847987'] as $prilUser) { ?>
          <?
          $usPartPril = \CUser::GetById($prilUser)->Fetch();
          ?>
          <?= $usPartPril['NAME'];?> <?= $usPartPril['SECOND_NAME'];?>
      <? } ?>
        &nbsp;</span>
                                                                <? } }  }?></td>
                                                </tr>


                                            <? }  ?>
                                            <?  if ($select==4) {  ?>
                                                <? foreach ($arPril as $iPril) { ?>

                                                    <tr class="odd">
                                                        <td style="display: none;"></td>
                                                        <td>
            <span style="display: block; font-weight: bold; width: 100%;">

                <?= $iPril['UF_CRM_14_1730820394442'];?> </span>
                                                        </td>


                                                        <td>
                                                            <span style="display: block; font-weight: bold; width: 100%;"> <?= getTypeS($iPril['UF_CRM_14_1696588270']);?></span>
                                                        </td>

                                                        <td>

                                                            <?
                                                            $idComp = $iPril['COMPANY_ID'];
                                                            #$company = \CCrmCompany::GetById($item['COMPANY_ID'], false);
                                                            if ($idComp>0) {
                                                                foreach ($arCompany as $iComp) {
                                                                    if ($idComp==$iComp['ENTITY_ID']) {
                                                                        $container_company = $iComp;
                                                                    }
                                                                }
                                                            } else { $container_company['RQ_COMPANY_NAME'] = ''; }
                                                            ?>

                                                            <span title="2<?= $container_company['RQ_COMPANY_NAME'];?>" style="display: block; font-weight: bold; width: 100%;">
    <?
    if (!empty($container_company['RQ_COMPANY_NAME'])) {
        ?>


        <?= $container_company['RQ_COMPANY_NAME'];?>

    <? } else { ?>

        <?
        foreach ($arContactD as $keyContact) {
            if ($iPril['CONTACT_ID']==$keyContact['ID']) {
                $fullNameTitle = $keyContact['LAST_NAME']." ".$keyContact['NAME']." ".$keyContact['SECOND_NAME'];
                $fullName = $fullNameTitle;
                ?>
                <?= $fullName ;?>
            <?  } } } ?>&nbsp;</span>
                                                        </td>





                                                        <td style="display: none;">

                                                            <span style="display: block; font-weight: bold; width: 100%;"> <?= $iPril['TITLE'];?> </span>
                                                        </td>



                                                        <td>
                                                            <span style="display: block; font-weight: bold; width: 100%;"> <?= $iPril['UF_CRM_14_1696848468084']; ?> </span>
                                                        </td>


                                                        <td>

        <span style="display: block; font-weight: bold; width: 100%;">
        <? $aa = $iPril['UF_CRM_14_1696848478'];
        ?>
        <?= $aa; ?> </span>

                                                        </td>


                                                        <td>
        <span style="display: block; font-weight: bold; width: 100%;">
                <?= getStage($iPril['STAGE_ID']);?>&nbsp;
            </span>
                                                        </td>


                                                        <td>

        <span style="display: block; font-weight: bold; width: 100%;">
                <?= $iPril['UF_CRM_14_1696848511'];?>&nbsp;
            </span>
                                                        </td>


                                                        <td>
        <span style="display: block; font-weight: bold; width: 100%;">

                <? foreach ($arCompany as $i) {
                    if ($i['ENTITY_ID']==$iPril['COMPANY_ID']) {
                        ?>


                        <?= $i['RQ_INN'];?>
                    <? } } ?>
            &nbsp;</span>
                                                        </td>

                                                        <td>
     <span style="display: block; font-weight: bold; width: 100%;"> <?
         $deal = \CCrmDeal::GetById($iPril['UF_CRM_14_1733844404'], false);
         ?>
         <? if (!empty($deal['TITLE'])) { ?>

             <?
             $dd = $deal['TITLE'];
             ?>

             <?= $dd; ?> <? } ?>
        &nbsp; </span>
                                                        </td>





                                                        <td>
        <span style="display: block; font-weight: bold; width: 100%;">
                <?
                $bgpPril = \CCrmCompany::GetById($iPril['MYCOMPANY_ID'], false);
                ?>
            <?= $bgpPril['TITLE'];?>&nbsp;
            </span>
                                                        </td>



                                                        <td><span style="display: block; font-weight: bold; width: 100%;">
                <?= getTypeS($iPril['UF_CRM_14_1696848691']);?>&nbsp;
            </span>
                                                        </td>

                                                        <td>
            <span style="display: block; font-weight: bold; width: 100%;">
              <?
              foreach (unserialize($iPril['UF_CRM_14_1696848041']) as $itemEl) {

                  echo getTypeS($itemEl);

              };?>
                 &nbsp;
            </span>
                                                        </td>



                                                        <td style="display: none;">
        <span style="display: block; font-weight: bold; width: 100%;"><? foreach (unserialize($iPril['UF_CRM_14_1696847987']) as $prilUser) { ?>
                <?
                $usPartPril = \CUser::GetById($prilUser)->Fetch();
                ?>
                <?= $usPartPril['LAST_NAME'];?> <?= $usPartPril['NAME'];?> <?= $usPartPril['SECOND_NAME'];?>
            <? } ?></span>
                                                        </td>



                                                    </tr>
                                                <? } } }  else { ?>

                                            <? foreach ($dataItemPril as  $itemPril) { ?>
                                                <? $dataPril = $itemPril;

                                                ?>
                                                <tr class="odd">
                                                    <td style="display: none;"></td>
                                                    <td>
            <span style="display: block; font-weight: bold; width: 100%;">

                <?= $dataPril['UF_CRM_14_1730820394442'];?></span></td>



                                                    <td>
                                                        <span style="display: block; font-weight: bold; width: 100%;"> <?= getTypeS($dataPril['UF_CRM_14_1696588270']);?> </span>
                                                    </td>


                                                    <td style="display: none;">
                                                        <span style="display: block; font-weight: bold; width: 100%;"> <?= $dataPril['TITLE'];?> </span>
                                                    </td>

                                                    <td>
     <span style="display: block; font-weight: bold; width: 100%;"> <?
         $prilCompany = \CCrmCompany::GetById($dataPril['COMPANY_ID'], false);

         if (!empty($prilCompany['TITLE'])) {
             ?>
             <?= $prilCompany['TITLE'];?>

         <? } else { ?>

             <?
             foreach ($arContactD as $keyContact) {
                 if ($dataPril['CONTACT_ID']==$keyContact['ID']) { ?>
                     <?
                     $fullNameTitle = $keyContact['LAST_NAME']." ".$keyContact['NAME']." ".$keyContact['SECOND_NAME'];
                     $fullName = $fullNameTitle;
                     ?>

                 <?  } } ?> <?= $fullName ;?> <? } ?>
    &nbsp;</span>
                                                    </td>



                                                    <td>
                                                        <span style="display: block; font-weight: bold; width: 100%;"> <?= $dataPril['UF_CRM_14_1696848468084'];?> </span>
                                                    </td>


                                                    <td>

                                                        <span style="display: block; font-weight: bold; width: 100%;"> <?= $dataPril['UF_CRM_14_1696848478'];?> </span>
                                                    </td>


                                                    <td>
    <span style="display: block; font-weight: bold; width: 100%;">
                <?= getStage($dataPril['STAGE_ID']);?>&nbsp;
            </span>
                                                    </td>


                                                    <td>

        <span style="display: block; font-weight: bold; width: 100%;">
                <?= $dataPril['UF_CRM_14_1696848511'];?>&nbsp;
            </span>
                                                    </td>


                                                    <td>
    <span style="display: block; font-weight: bold; width: 100%;">

                <? foreach ($arCompany as $i) {
                    if ($i['ENTITY_ID']==$dataPril['COMPANY_ID']) {
                        ?>
                        <?= $i['RQ_INN'];?>
                    <? } } ?>
            &nbsp;</span>
                                                    </td>


                                                    <td>
        <span style="display: block; font-weight: bold; width: 100%;"> <?
            $deal = \CCrmDeal::GetById($dataPril['UF_CRM_14_1733844404'], false);
            ?>
            <? if (!empty($deal['TITLE'])) { ?>
                <?= $deal['TITLE'];?> <? } ?>&nbsp; </span>
                                                    </td>


                                                    <td>
    <span style="display: block; font-weight: bold; width: 100%;">
                <?
                $bgpPril = \CCrmCompany::GetById($dataPril['MYCOMPANY_ID'], false);
                ?>
        <?= $bgpPril['TITLE'];?>&nbsp;
            </span>
                                                    </td>






                                                    <td><span style="display: block; font-weight: bold; width: 100%;">
                <?= getTypeS($dataPril['UF_CRM_14_1696848691']);?>&nbsp;
            </span>
                                                    </td>







                                                    <td><span style="display: block; font-weight: bold; width: 100%;">
                <?
                foreach (unserialize($dataPril['UF_CRM_14_1696848041']) as $itemEl) { echo getTypeS($itemEl)." "; };?>
                 &nbsp;
            </span>
                                                    </td>



                                                    <td style="display: none;"><span style="display: block; font-weight: bold; width: 100%;"><? foreach (unserialize($dataPril['UF_CRM_14_1696847987']) as $prilUser) { ?>
                                                                <?
                                                                $usPartPril = \CUser::GetById($prilUser)->Fetch();
                                                                ?>
                                                                <?= $usPartPril['LAST_NAME'];?> <?= $usPartPril['NAME'];?> <?= $usPartPril['SECOND_NAME'];?>
                                                            <? } ?></span>
                                                    </td>


                                                </tr>
                                            <? } } ?>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Таблица закончилась !-->









    <div style="margin-top: -115px;" class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div <?php if ($select <> 1) { ?> id="responsive-datatable_wrapper" <? } else { ?> id="datatable" <? } ?> data-inner="<?= $select;?>" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row"><div class="row"><div class="col-sm-12">
                                    <table id="responsive-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                        <tr role="row">


                                            <th class="border-bottom-0 sorting" style="display: none"></th>
                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width:80px;">ID</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 379.094px;">Тип</th>

                                            <th style="display: none" class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 180.281px;"></th>

                                            <th class="border-bottom-0 sorting sorting_asc" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 243.578px;">Контрагент</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 50px;">№</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspanё="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 200.281px;">Дата От</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">Статус</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">Дата До</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">ИНН</th>


                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">Проект</th>


                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">BGP <br>Юр. лицо</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">Форма подписания</th>

                                            <th class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">ЦФО</th>

                                            <th style="display: none;" class="border-bottom-0 sorting" tabindex="0" aria-controls="file-datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 155.703px;">Владелец документа</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?
                                        foreach ($dataItemPril as  $itemPril) {
                                            if ($select==4) {
                                                $arPril[] = $itemPril;
                                            }
                                        }
                                        $arPril = getUniqueItem($arPril);
                                        ?>

                                        <? if ($select !==3 ) { ?>
                                            <? $dataItem = getUniqueItem($dataItem); ?>
                                            <? foreach ($dataItem as $item) { ?>

                                                <?

                                                if (($USER->GetID()==333) && ($iii==0)) {
                                                    /*
                                            $entityRequisite = new \Bitrix\Crm\EntityRequisite;
                                            $rsRequisite = $entityRequisite->getList([
                                               "select"=>array("*"),
                                               "filter"=>array("ENTITY_ID"=> 2777,"ENTITY_TYPE_ID"=>CCrmOwnerType::Company),
                                               "order"=>array("SORT"=>"desc","ID"=>"desc")

                                            ]);
                                            $arRequisite =  $rsRequisite->fetchAll();





                                            $factoryPrilItem = Service\Container::getInstance()->getFactory('156');
                                            $dataItemPrilItem = $factoryPrilItem->getItems([
                                                'filter' => ['ID' => 36],
                                                'select' => ['*', 'ID']
                                            ]);

                                                    foreach ($dataItemPrilItem as $itemPrilData) {
                                            echo "<pre>";
                                            print_r(date('Ymd', strtotime($itemPrilData['BEGINDATE'])));
                                            echo "</pre>";
                                                    }
                                            $iii++;

                                            */


                                                }



                                                $dPril = array();
                                                foreach ($dataItemPril as  $itemPril) {
                                                    if ($itemPril['UF_CRM_14_1733843020']==$item['ID']) {
                                                        $dPril[] = $itemPril;
                                                    }
                                                }
                                                ?>


                                                <tr class="odd">
                                                    <td style="display: none;"></td>
                                                    <td style="padding-left: 0px; padding-right: 0px;">

     <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
    	<? if ($select<>3) { ?>
            <a target="_blank" href="https://bit.bgplaw.com/page/dogovory/dogovory/type/158/details/<?= $item['ID'];?>/">
                   <?= $item['UF_CRM_10_1730819805760'];?></a>
        <? } ?>&nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') {
                                                                    ?>
                                                                    <br>
                                                                    <span style="display: block; margin-top: 6px;">
            	<a target="_blank" style="margin-top: 6px;" href="https://bit.bgplaw.com/page/dogovory/prilozheniya/type/156/details/<?= $dataPril['ID'];?>/">
            	<?= $dataPril['UF_CRM_14_1730820394442'];?> </a></span>
                                                                <? } }
                                                        }?>

                                                    </td>


                                                    <td style="padding-left: 0px; padding-right: 0px;">
    	<span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;"><?
            if ($select<>3) {
                $r = getTypeS($item['UF_CRM_10_1692807563']);
                echo $r;
            }
            ?>      &nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {

                                                            foreach ($dPril as $dataPril) {

                                                                if ($dataPril['TITLE'] <>'') { ?> <br><b style="display: block; margin-top: 6px; "> <?= getTypeS($dataPril['UF_CRM_14_1696588270']);?> </b> <? } } } ?>
                                                    </td>


                                                    <td style="padding-left: 0px; padding-right: 0px;">
    <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <? if ($select<>3) { ?>
            <?
            $idComp = $item['COMPANY_ID'];
            $container_company = array();
            #$company = \CCrmCompany::GetById($item['COMPANY_ID'], false);
            if ($idComp>0) {
                foreach ($arCompany as $iComp) {
                    if ($idComp==$iComp['ENTITY_ID']) {
                        $container_company = $iComp;
                    }
                }
            } else { $container_company['RQ_COMPANY_NAME'] = ''; }
            if ( (!empty($container_company['RQ_COMPANY_NAME'])) or (!empty($container_company['RQ_FIRST_NAME'])) ) {

                if (!empty($container_company['RQ_COMPANY_NAME'])) {
                    ?>

                    <a title='3<?= $container_company['RQ_COMPANY_NAME'];?>' href="https://bit.bgplaw.com/crm/company/details/<?= $container_company['ENTITY_ID'];?>/">

   <?
   $tmpName = mb_substr($container_company['RQ_COMPANY_NAME'], 0, 20);
   ?>
                        <?= $tmpName;?><? if ((!empty($container_company['RQ_COMPANY_NAME'])) && (mb_strlen($container_company['RQ_COMPANY_NAME'])>21)) { ?>...<? } ?></a>
                <? } else { ?>
                    <?
                    $nm = "ИП ".$container_company['RQ_LAST_NAME']." ".$container_company['RQ_FIRST_NAME']." ".$container_company['RQ_SECOND_NAME'];
                    $tmpName = mb_substr($nm, 0, 20);
                    ?>
                    <a title="<?= $nm;?>" href="https://bit.bgplaw.com/crm/company/details/<?= $container_company['ENTITY_ID'];?>/">


   <?= $tmpName;?><? if ((!empty($nm)) && (mb_strlen($nm)>21)) { ?>...<? } ?></a>
                <? } ?>


            <? } elseif  (!empty($container_company['RQ_NAME'])) { ?>
                <?
                $nameIP = $container_company['RQ_NAME']." ".$container_company['RQ_LAST_NAME'];
                ?>
                <a title='я<?= $container_company['RQ_NAME'];?>' href="https://bit.bgplaw.com/crm/company/details/<?= $container_company['ENTITY_ID'];?>/">
            ИП <?= mb_substr($container_company['RQ_NAME'], 0, 20);?><? if (mb_strlen($container_company['RQ_NAME'])>20) {?>...<? }?>
        </a>
                }

            <? } else { ?>
                <?
                foreach ($arContactD as $keyContact) {
                    if ($item['CONTACT_ID']==$keyContact['ID']) { ?>
                        <?
                        $fullNameTitle = $keyContact['LAST_NAME']." ".$keyContact['NAME']." ".$keyContact['SECOND_NAME'];
                        $fullName = mb_substr($fullNameTitle, 0, 20);
                        ?>
                        <a title='4<?= $fullNameTitle;?>' href="https://bit.bgplaw.com/crm/contact/details/<?= $keyContact['ID'];?>/"><?= $fullName ;?><? if (mb_strlen($fullNameTitle)>20) { ?>...<? } ?></a>
                    <?  } } } }?>
&nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {

                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <?
                                                                    $idComp = $dataPril['COMPANY_ID'];
                                                                    if ($idComp>0) {
                                                                        foreach ($arCompany as $iComp) {
                                                                            if ($idComp==$iComp['ENTITY_ID']) {
                                                                                $container_company = $iComp;
                                                                            }
                                                                        }
                                                                    } else { $container_company['RQ_COMPANY_NAME'] = ''; }
                                                                    ?>
                                                                    <br><span style="display: block; margin-top: 6px;"> <?
                                                                        # $prilCompany = \CCrmCompany::GetById($dataPril['COMPANY_ID'], false);
                                                                        if (!empty($container_company['RQ_COMPANY_NAME'])) {
                                                                            ?>
                                                                            <a href="https://bit.bgplaw.com/crm/company/details/<?= $container_company['ENTITY_ID'];?>/" title='<?= $container_company['RQ_COMPANY_NAME'];?>'>
    <?= mb_substr($container_company['RQ_COMPANY_NAME'], 0, 20);?><? if (mb_strlen($container_company['RQ_COMPANY_NAME'])>20) { ?>...<? } ?>&nbsp;
</a>
                                                                        <? } else {
                                                                            foreach ($arContactD as $keyContact) {
                                                                                if ($dataPril['CONTACT_ID']==$keyContact['ID']) { ?>
                                                                                    <?
                                                                                    $fullNameTitle = $keyContact['LAST_NAME']." ".$keyContact['NAME']." ".$keyContact['SECOND_NAME'];
                                                                                    $fullName = mb_substr($fullNameTitle, 0, 20);
                                                                                    ?>
                                                                                    <a title='<?= $fullNameTitle;?>' href="https://bit.bgplaw.com/crm/contact/details/<?= $keyContact['ID'];?>/"><?= $fullName ;?><? if (mb_strlen($fullName)>20) { ?>...<? } ?></a>
                                                                                <? } } }?>
 </span>
                                                                <? } } }?>
                                                    </td>



                                                    <td style="display: none" >
                                                        <? if ($select<>3) { ?>
                                                            <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;"> <?= $item['TITLE'];?></span>&nbsp;
                                                        <? } ?>
                                                        <? if (($select==1) or ($select==3)) {

                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?> <br><b style="display: block; margin-top: 6px; "> <?= $dataPril['TITLE'];?> &nbsp;</b> <? } }  }?>
                                                    </td>






                                                    <td style="padding-left: 0px; padding-right: 0px;">
                                                        <? if ($select<>3) { ?>
                                                            <span title='<?= $item['UF_CRM_10_1692019862058'];?>' style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
             	<? $compName = mb_substr($item['UF_CRM_10_1692019862058'], 0, 15);
                ?>
                                                                <?= $compName;?>
                                                                <? if (mb_strlen($item['UF_CRM_10_1692019862058'])>16) {?>...<? } ?>&nbsp;</span>
                                                        <? } ?>
                                                        <? if (($select==1) or ($select==3)) {

                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?> <br><span title='<?= $dataPril['UF_CRM_14_1696848468084'];?>' style="display: block; margin-top: 6px;"> <?= mb_substr($dataPril['UF_CRM_14_1696848468084'], 0, 15);?> <? if (mb_strlen($dataPril['UF_CRM_14_1696848468084'])>15) { ?>...<? } ?>&nbsp;</span> <? } } }?>
                                                    </td>


                                                    <td style="padding-left: 0px; padding-right: 0px;">
                                                        <? if ($select<>3) { ?>
                                                            <span style="display: none;"><?= date('Ymd', strtotime($item['UF_CRM_10_1692010426']));?></span>
                                                            <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <?= $item['UF_CRM_10_1692010426'];?>
   &nbsp; </span>
                                                        <? } ?>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?> <br><b style="display: block; margin-top: 6px; "> <?= $dataPril['UF_CRM_14_1696848478'];?> </b> <? } }  }?>
                                                    </td>




                                                    <td style="padding-left: 0px; padding-right: 0px;">
        <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <?= getStage($item['STAGE_ID']);?>&nbsp;
    </span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {

                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">
                <?= getStage($dataPril['STAGE_ID']);?>&nbsp;
            </span>
                                                                <? } } }?>
                                                    </td>


                                                    <td style="padding-left: 0px; padding-right: 0px;">
                                                        <span style="display: none;"><?= date('Ymd', strtotime($item['UF_CRM_10_1692010502']));?></span>
                                                        <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
            <?= $item['UF_CRM_10_1692010502'];?> &nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">
                <?= $dataPril['UF_CRM_14_1696848511'];?>&nbsp;
            </span>
                                                                <? } } }?>
                                                    </td>


                                                    <td style="padding-left: 0px; padding-right: 0px;">
    <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
    <? foreach ($arCompany as $i) {
        if ($i['ENTITY_ID']==$item['COMPANY_ID']) {
            ?>


            <?= $i['RQ_INN'];?>
        <? } } ?>
	&nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">

                <? foreach ($arCompany as $i) {
                    if ($i['ENTITY_ID']==$dataPril['COMPANY_ID']) {
                        ?>


                        <?= $i['RQ_INN'];?>
                    <? } } ?>
            &nbsp;</span>
                                                                <? } } } ?>
                                                    </td>

                                                    <td style="padding-left: 0px; padding-right: 0px;">
                                                        <?
                                                        if ($select<>3) {
                                                            $cDeal = \CCrmDeal::GetById($item['UF_CRM_10_1733853669'], false);
                                                            ?> <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
	<? if (!empty($cDeal['TITLE'])) { ?>
        <a title='<?= $cDeal['TITLE'];?>' href="https://bit.bgplaw.com/crm/deal/details/<?= $item['UF_CRM_10_1733853669'];?>/">
        <? $dTmpName = mb_substr($cDeal['TITLE'], 0, 20, 'utf-8'); ?>
            <?= $dTmpName;?>
            <? if (mb_strlen($cDeal['TITLE'])>21) {?>...<? } ?></a> <? } ?> &nbsp;</span> <? } ?>

                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;"> <?
                                                                        $deal = \CCrmDeal::GetById($dataPril['UF_CRM_14_1733844404'], false);
                                                                        ?>
                                                                        <? if (!empty($deal['TITLE'])) { ?>
                                                                            <a title='<?= $deal['TITLE'];?>' href="https://bit.bgplaw.com/crm/deal/details/<?= $dataPril['UF_CRM_14_1733844404'];?>/"><?= mb_substr($deal['TITLE'], 0, 20);?><? if (mb_strlen($deal['TITLE'])>21) {?>...<? } ?></a> <? } ?>&nbsp; </span>
                                                                <? } } }?>
                                                    </td>




                                                    <td style="padding-left: 0px; padding-right: 0px;">
                                                        <?
                                                        $bgp = \CCrmCompany::GetById($item['MYCOMPANY_ID'], false);
                                                        ?>
                                                        <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">  <?= $bgp['TITLE'];?> &nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">

                <?
                $bgpPril = \CCrmCompany::GetById($dataPril['MYCOMPANY_ID'], false);
                ?>

                                                                        <?= $bgpPril['TITLE'];?>&nbsp;
            </span>
                                                                <? } } }?>
                                                    </td>






                                                    <td style="padding-left: 0px; padding-right: 0px;">

     <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <?= getTypeS($item['UF_CRM_10_1696862579']);?>&nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">
                <?= getTypeS($dataPril['UF_CRM_14_1696848691']);?>&nbsp;
            </span>
                                                                <? } } }?>
                                                    </td>

                                                    <td style="padding-left: 0px; padding-right: 0px;">
            <span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
           <? if (unserialize($item['UF_CRM_10_1696847511'])>0) {
               foreach (unserialize($item['UF_CRM_10_1696847511']) as $itemEl) {
                   $lenStr = getTypeS($itemEl);
                   echo mb_substr($lenStr, 0, 21);
                   if (mb_strlen($lenStr)>23) {
                       echo "...";
                   };

               };?>
           <? } else { ?><? } ?>&nbsp;</span>
                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?>
                                                                    <br><span style="display: block; margin-top: 6px;">
                <?
                foreach (unserialize($dataPril['UF_CRM_14_1696848041']) as $itemEl) {
                    $strItem = getTypeS($itemEl);
                    echo mb_substr($strItem, 0, 21);
                    if  (mb_strlen($strItem)>23) {
                        echo "...";
                    };
                    echo " ";
                };?>&nbsp;

            </span>
                                                                <? } } } ?>
                                                    </td>



                                                    <td style="display: none;">
    	<span style="display: block; font-weight: bold; <? if ($select<>4) { ?> background: #efefef; <? } ?> width: 100%;">
        <? foreach ($item['UF_CRM_10_1696599768'] as $itemPart) {
            $usPart = \CUser::GetById($itemPart)->Fetch(); ?>

            <a href="https://bit.bgplaw.com/company/personal/user/<?= $usPart['ID'];?>/"><?= $usPart['LAST_NAME'];?> <?= $usPart['NAME'];?> <?= $usPart['SECOND_NAME'];?></a>&nbsp;

        <? } ?>&nbsp;</span>

                                                        <? if (($select==1) or ($select==3)) {
                                                            foreach ($dPril as $dataPril) {
                                                                if ($dataPril['TITLE'] <>'') { ?> <br>
                                                                    <span style="display: block; font-weight: bold; width: 100%; margin-top: 6px;">

      <?
      foreach ($dataPril['UF_CRM_14_1696847987'] as $prilUser) { ?>
          <?
          $usPartPril = \CUser::GetById($prilUser)->Fetch();
          ?>
          <a href="https://bit.bgplaw.com/company/personal/user/<?= $prilUser;?>/"><?= $usPartPril['LAST_NAME'];?> <?= $usPartPril['NAME'];?> <?= $usPartPril['SECOND_NAME'];?></a>
      <? } ?>
        &nbsp;</span>
                                                                <? } }  }?></td>
                                                </tr>


                                            <? }  ?>
                                            <?  if ($select==4) {  ?>
                                                <? foreach ($arPril as $iPril) { ?>

                                                    <tr class="odd">
                                                        <td style="display: none;"></td>
                                                        <td>
            <span style="display: block; font-weight: bold; width: 100%;">
            	<a target="_blank" href="https://bit.bgplaw.com/page/dogovory/prilozheniya/type/156/details/<?= $iPril['ID'];?>/">
            	<?= $iPril['UF_CRM_14_1730820394442'];?> </a></span>
                                                        </td>


                                                        <td>
                                                            <span style="display: block; font-weight: bold; width: 100%;"> <?= mb_substr(getTypeS($iPril['UF_CRM_14_1696588270']), 0, 20);?><? if (mb_strlen(getTypeS($iPril['UF_CRM_14_1696588270']))>22) {?>...!<? } ?></span>
                                                        </td>

                                                        <td>

                                                            <?
                                                            $idComp = $iPril['COMPANY_ID'];
                                                            #$company = \CCrmCompany::GetById($item['COMPANY_ID'], false);
                                                            if ($idComp>0) {
                                                                foreach ($arCompany as $iComp) {
                                                                    if ($idComp==$iComp['ENTITY_ID']) {
                                                                        $container_company = $iComp;
                                                                    }
                                                                }
                                                            } else { $container_company['RQ_COMPANY_NAME'] = ''; }
                                                            ?>

                                                            <?
                                                            #$prilCompany = \CCrmCompany::GetById($iPril['COMPANY_ID'], false);

                                                            ?>
                                                            <span title="1<?= $container_company['RQ_COMPANY_NAME'];?>" style="display: block; font-weight: bold; width: 100%;">
    <?
    if (!empty($container_company['RQ_COMPANY_NAME'])) {
        ?>
        <span style="display: none;"><?= $container_company['RQ_COMPANY_NAME'];?></span>
        <a title='<?= $container_company['RQ_COMPANY_NAME'];?>' href="https://bit.bgplaw.com/crm/company/details/<?= $container_company['ENTITY_ID'];?>/">

	<?= mb_substr($container_company['RQ_COMPANY_NAME'], 0, 20);?><? if (mb_strlen($container_company['RQ_COMPANY_NAME'])>20) { ?>...<? } ?></a>

    <? } else { ?>

        <?
        foreach ($arContactD as $keyContact) {
            if ($iPril['CONTACT_ID']==$keyContact['ID']) {
                $fullNameTitle = $keyContact['LAST_NAME']." ".$keyContact['NAME']." ".$keyContact['SECOND_NAME'];
                echo '<span style="display: none;">'.$fullNameTitle.'</span>';
                $fullName = mb_substr($fullNameTitle, 0, 20);
                ?>
                <a title='<?= $fullNameTitle;?>' href="https://bit.bgplaw.com/crm/contact/details/<?= $keyContact['ID'];?>/"><?= $fullName ;?><? if (mb_strlen($fullName)>20) { ?>...<? } ?></a>
            <?  } } } ?>&nbsp;</span>
                                                        </td>





                                                        <td style="display: none;">

                                                            <span style="display: block; font-weight: bold; width: 100%;"> <?= $iPril['TITLE'];?> </span>
                                                        </td>



                                                        <td>
                                                            <span style="display: block; font-weight: bold; width: 100%;"> <?= mb_substr($iPril['UF_CRM_14_1696848468084'], 0, 15);?> </span>
                                                        </td>


                                                        <td>
                                                            <span style="display: none;"><?= date('Ymd', strtotime($iPril['UF_CRM_14_1696848478']));?></span>
                                                            <span style="display: block; font-weight: bold; width: 100%;">
    	<? $aa = mb_substr($iPril['UF_CRM_14_1696848478'], 0, 15);
        ?>
                                                                <?= $aa; ?><? if (mb_strlen($aa)>16) {?>...<? }?> </span>

                                                        </td>


                                                        <td>
    	<span style="display: block; font-weight: bold; width: 100%;">
                <?= getStage($iPril['STAGE_ID']);?>&nbsp;
            </span>
                                                        </td>


                                                        <td>
                                                            <span style="display: none;"><?= date('Ymd', strtotime($iPril['UF_CRM_14_1696848511']));?></span>
                                                            <span style="display: block; font-weight: bold; width: 100%;">
                <?= $iPril['UF_CRM_14_1696848511'];?>&nbsp;
            </span>
                                                        </td>


                                                        <td>
    	<span style="display: block; font-weight: bold; width: 100%;">

                <? foreach ($arCompany as $i) {
                    if ($i['ENTITY_ID']==$iPril['COMPANY_ID']) {
                        ?>


                        <?= $i['RQ_INN'];?>
                    <? } } ?>
            &nbsp;</span>
                                                        </td>

                                                        <td>
     <span style="display: block; font-weight: bold; width: 100%;"> <?
         $deal = \CCrmDeal::GetById($iPril['UF_CRM_14_1733844404'], false);
         ?>
         <? if (!empty($deal['TITLE'])) { ?>
             <a title='<?= $deal['TITLE'];?>' href="https://bit.bgplaw.com/crm/deal/details/<?= $deal['ID'];?>/">
        	<?
            $dd = mb_substr($deal['TITLE'], 0, 20);
            ?>

                 <?= $dd; ?><? if (mb_strlen($dd)>21) {?>...<? } ?></a> <? } ?>
        &nbsp; </span>
                                                        </td>





                                                        <td>
    	<span style="display: block; font-weight: bold; width: 100%;">
                <?
                $bgpPril = \CCrmCompany::GetById($iPril['MYCOMPANY_ID'], false);
                ?>
            <?= $bgpPril['TITLE'];?>&nbsp;
            </span>
                                                        </td>



                                                        <td><span style="display: block; font-weight: bold; width: 100%;">
                <?= getTypeS($iPril['UF_CRM_14_1696848691']);?>&nbsp;
            </span>
                                                        </td>


                                                        <?
                                                        # ВОТ ТУТ
                                                        ?>
                                                        <td>
            <span style="display: block; font-weight: bold; width: 100%;">
              <?
              foreach (unserialize($iPril['UF_CRM_14_1696848041']) as $itemEl) {

                  echo mb_substr(getTypeS($itemEl), 0, 21);
                  if (mb_strlen(getTypeS($itemEl))>22) {
                      echo "...";
                  };
                  echo " ";

              };?>
                 &nbsp;
            </span>
                                                        </td>



                                                        <td style="display: none;">
        <span style="display: block; font-weight: bold; width: 100%;"><? foreach (unserialize($iPril['UF_CRM_14_1696847987']) as $prilUser) { ?>
                <?
                $usPartPril = \CUser::GetById($prilUser)->Fetch();
                ?>
                <a href="https://bit.bgplaw.com/company/personal/user/<?= $prilUser;?>/"><?= $usPartPril['LAST_NAME'];?> <?= $usPartPril['NAME'];?> <?= $usPartPril['SECOND_NAME'];?></a>
            <? } ?></span>
                                                        </td>



                                                    </tr>

                                                <? } } }  else { ?>

                                            <? foreach ($dataItemPril as  $itemPril) { ?>
                                                <? $dataPril = $itemPril;

                                                ?>
                                                <tr class="odd">
                                                    <td style="display: none;"></td>
                                                    <td>
            <span style="display: block; font-weight: bold; width: 100%;">
            	<a target="_blank" href="https://bit.bgplaw.com/page/dogovory/prilozheniya/type/156/details/<?= $dataPril['ID'];?>/">
            	<?= $dataPril['UF_CRM_14_1730820394442'];?> </a></span></td>



                                                    <td>
                                                        <span style="display: block; font-weight: bold; width: 100%;"> <?= getTypeS($dataPril['UF_CRM_14_1696588270']);?> </span>
                                                    </td>


                                                    <td style="display: none;"><span style="display: block; font-weight: bold; width: 100%;"> <?= $dataPril['TITLE'];?> </span>
                                                    </td>

                                                    <td>
     <span style="display: block; font-weight: bold; width: 100%;"> <?
         $prilCompany = \CCrmCompany::GetById($dataPril['COMPANY_ID'], false);

         if (!empty($company['TITLE'])) {
             ?>
             <span style="display: none;"><?= $company['TITLE'];?></span>
             <a title='<?= $prilCompany['TITLE'];?>' href="https://bit.bgplaw.com/crm/company/details/<?= $prilCompany['ID'];?>/"><?= mb_substr($prilCompany['TITLE'], 0, 25);?><? if (!empty($prilCompany['TITLE'])) { ?>...<? } ?></a>

         <? } else { ?>

             <?
             foreach ($arContactD as $keyContact) {
                 if ($dataPril['CONTACT_ID']==$keyContact['ID']) { ?>
                     <?
                     $fullNameTitle = $keyContact['LAST_NAME']." ".$keyContact['NAME']." ".$keyContact['SECOND_NAME'];
                     $fullName = mb_substr($fullNameTitle, 0, 20);
                     ?>
                     <a title='<?= $fullNameTitle;?>' href="https://bit.bgplaw.com/crm/contact/details/<?= $keyContact['ID'];?>/"><?= $fullName ;?><? if (mb_strlen($fullName)>21) { ?>...<? } ?></a>
                 <?  } } } ?>
    &nbsp;</span>
                                                    </td>



                                                    <td>
                                                        <span style="display: block; font-weight: bold; width: 100%;"> <?= mb_substr($dataPril['UF_CRM_14_1696848468084'], 0, 15);?> </span>
                                                    </td>


                                                    <td>
                                                        <span style="display: none;"><?= date('Ymd', strtotime($dataPril['UF_CRM_14_1696848478']));?></span>
                                                        <span style="display: block; font-weight: bold; width: 100%;"> <?= $dataPril['UF_CRM_14_1696848478'];?> </span>
                                                    </td>


                                                    <td>
	<span style="display: block; font-weight: bold; width: 100%;">
                <?= getStage($dataPril['STAGE_ID']);?>&nbsp;
            </span>
                                                    </td>


                                                    <td><span style="display: none;"><?= date('Ymd', strtotime($dataPril['UF_CRM_14_1696848511']));?></span>
                                                        <span style="display: block; font-weight: bold; width: 100%;">
                <?= $dataPril['UF_CRM_14_1696848511'];?>&nbsp;
            </span>
                                                    </td>


                                                    <td>
	<span style="display: block; font-weight: bold; width: 100%;">

                <? foreach ($arCompany as $i) {
                    if ($i['ENTITY_ID']==$dataPril['COMPANY_ID']) {
                        ?>
                        <?= $i['RQ_INN'];?>
                    <? } } ?>
            &nbsp;</span>
                                                    </td>


                                                    <td>
    	<span style="display: block; font-weight: bold; width: 100%;"> <?
            $deal = \CCrmDeal::GetById($dataPril['UF_CRM_14_1733844404'], false);
            ?>
            <? if (!empty($deal['TITLE'])) { ?>
                <a title='<?= $deal['TITLE'];?>' href="https://bit.bgplaw.com/crm/deal/details/<?= $deal['ID'];?>/"><?= mb_substr($deal['TITLE'], 0, 20);?><? if (mb_strlen($deal['TITLE'])>21) {?>...<?}?></a> <? } ?>&nbsp; </span>
                                                    </td>


                                                    <td>
    <span style="display: block; font-weight: bold; width: 100%;">
                <?
                $bgpPril = \CCrmCompany::GetById($dataPril['MYCOMPANY_ID'], false);
                ?>
        <?= $bgpPril['TITLE'];?>&nbsp;
            </span>
                                                    </td>






                                                    <td><span style="display: block; font-weight: bold; width: 100%;">
                <?= getTypeS($dataPril['UF_CRM_14_1696848691']);?>&nbsp;
            </span>
                                                    </td>







                                                    <td><span style="display: block; font-weight: bold; width: 100%;">
                <?
                foreach (unserialize($dataPril['UF_CRM_14_1696848041']) as $itemEl) { echo getTypeS($itemEl)." "; };?>
                 &nbsp;
            </span>
                                                    </td>



                                                    <td style="display: none;"><span style="display: block; font-weight: bold; width: 100%;"><? foreach (unserialize($dataPril['UF_CRM_14_1696847987']) as $prilUser) { ?>
                                                                <?
                                                                $usPartPril = \CUser::GetById($prilUser)->Fetch();
                                                                ?>
                                                                <a href="https://bit.bgplaw.com/company/personal/user/<?= $prilUser;?>/"><?= $usPartPril['LAST_NAME'];?> <?= $usPartPril['NAME'];?> <?= $usPartPril['SECOND_NAME'];?></a>
                                                            <? } ?></span>
                                                    </td>


                                                </tr>
                                            <? } } ?>



                                        </tbody>
                                    </table></div></div><div class="row"><div class="col-sm-12 col-md-12"></div><div class="col-sm-12 col-md-12"><div class="dataTables_paginate paging_simple_numbers" id="file-datatable_paginate"></div></div></div></div>
                    </div>
                </div>
            </div>
        </div>














        <!-- JQUERY JS -->
        <script src="assets/js/jquery.min.js"></script>

        <!-- BOOTSTRAP JS -->
        <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

        <!-- INPUT MASK JS-->
        <script src="assets/plugins/input-mask/jquery.mask.min.js"></script>

        <!-- SIDE-MENU JS -->
        <script src="assets/plugins/sidemenu/sidemenu.js"></script>

        <!-- TypeHeads -->
        <script src="assets/plugins/bootstrap5-typehead/autocomplete.js"></script>
        <script src="assets/js/typehead.js"></script>


        <!-- DATA TABLE JS-->
        <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
        <script src="assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
        <script src="assets/plugins/datatable/js/jszip.min.js"></script>
        <script src="assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
        <script src="assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
        <script src="assets/plugins/datatable/js/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatable/js/buttons.print.min.js"></script>
        <script src="/assets/plugins/datatable/js/buttons.colVis.min.js"></script>
        <script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
        <script src="assets/js/table-data.js"></script>

        <!-- SIDEBAR JS -->
        <script src="assets/plugins/sidebar/sidebar.js"></script>

        <!-- Perfect SCROLLBAR JS-->
        <script src="assets/plugins/p-scroll/perfect-scrollbar.js"></script>
        <script src="assets/plugins/p-scroll/pscroll.js"></script>
        <script src="assets/plugins/p-scroll/pscroll-1.js"></script>

        <!-- Color Theme js -->
        <script src="assets/js/themeColors.js"></script>

        <!-- Sticky js -->
        <script src="assets/js/sticky.js"></script>

        <!-- CUSTOM JS -->
        <script src="assets/js/custom.js"></script>


        <script src="https://unpkg.com/select2@4.1.0-rc.0/dist/js/select2.js"></script>
        <script>
            $(document).ready(function() {
                var xs = document.querySelectorAll('.col-sm-12 .col-md-6')[0];
                var listData = document.getElementById('responsive-datatable_wrapper');
                var elList = listData.querySelectorAll('.col-md-6')[0];
                elList.classList.remove('col-md-6');
                xs.classList.remove('col-md-6');
                xs.classList.remove('col-sm-12');
                setInterval(function () {
                    var x = document.getElementById('responsive-datatable');
                    var s = document.getElementById('responsive-datatable_length')
                    s.style = 'position: absolute; z-index: 5 !important; margin-top: calc(' + x.offsetHeight + 'px + 100px)';


                }, 400);


                $('.js-select2').select2({
                    placeholder: "Выберите город",
                    maximumSelectionLength: 2,
                    language: "ru"
                });

            });
        </script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>