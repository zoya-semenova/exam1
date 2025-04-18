<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="sidebar-nav" id="sidebar-nav">

<?
$previousLevel = 0;
foreach($arResult as $arItem)://echo "<pre>";print_r($arItem);exit;?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
    <li class="nav-item">
        <a class="nav-link <?if ($arItem["SELECTED"]):?> collapse <?else:?> collapsed <?endif?>" data-bs-target="#<?=$arItem["LINK"]?>" data-bs-toggle="collapse"
           href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>">

            <i class="bi bi-menu-button-wide"></i><span><?=$arItem["TEXT"]?></span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
                <ul id="<?=$arItem["LINK"]?>" class="nav-content collapse <?if ($arItem["SELECTED"]):?> show<?endif?>" data-bs-parent="#sidebar-nav">
		<?else:?>
			<li>
                <a href="<?=$arItem["LINK"]?>" class="parent<?if ($arItem["SELECTED"]):?> item-selected<?endif?>">

                    <i class="bi bi-circle"></i><span><?=$arItem["TEXT"]?></span>
                </a>
				<ul>
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
                <li class="nav-item">
                    <a class="nav-link <?if ($arItem["SELECTED"]):?> collapse <?else:?> collapsed <?endif?>" data-bs-target="#<?=$arItem["LINK"]?>" data-bs-toggle="collapse"
                    href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>">

                        <i class="bi bi-menu-button-wide"></i><span><?=$arItem["TEXT"]?></span><i class="bi bi-chevron-down ms-auto"></i>
                    </a></li>
			<?else:?>
				<li><a href="<?=$arItem["LINK"]?>" <?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>>
                        <i class="bi bi-circle"></i><span><?=$arItem["TEXT"]?></span>
                    </a></li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
                <li class="nav-item">
                    <a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>">
                        <i class="bi bi-menu-button-wide"></i><span><?=$arItem["TEXT"]?></span><i class="bi bi-chevron-down ms-auto"></i></a></li>
			<?else:?>
				<li><a href="<?=$arItem["LINK"]?>" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>">
                        <i class="bi bi-circle"></i><span><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
<?endif?>
