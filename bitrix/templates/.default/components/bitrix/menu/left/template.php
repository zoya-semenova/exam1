<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

    <div class="services-list">
    <?
    foreach($arResult as $arItem):
        ?>
    <?if($arItem["SELECTED"]):?>
        <a href="<?=$arItem["LINK"]?>" class="active"><i class="bi bi-arrow-right-circle"></i><span><?=$arItem["TEXT"]?></span></a>
    <?else:?>
        <a href="<?=$arItem["LINK"]?>"><i class="bi bi-arrow-right-circle"></i><span><?=$arItem["TEXT"]?></span></a>
    <?endif?>
    <?endforeach?>
        </div>
<?endif?>