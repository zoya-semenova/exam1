<?
use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

Loader::includeModule('iblock');

$skuPropList = array();
$catalogs = array();

$arRealItemsIDs = $arParams['SIMPLE_PRODUCT'] ? array_keys($arParams['SIMPLE_PRODUCT']) : [];

if ($arResult['ITEMS']) {
	foreach ($arResult['ITEMS'] as &$arItem) {
		if (
			isset($arItem['OFFERS']) &&
			$arItem['OFFERS']
		) {
			foreach($arItem['OFFERS'] as $offerIndex => &$arOffer){
				if (
					$arParams['FILTER_PRICE_CODE'] &&
					is_array($arParams['FILTER_PRICE_CODE'])
				) {					
					if ($arOffer['PRICES']) {
						$arOffer['MIN_PRICE'] = [];
	
						foreach ($arOffer['PRICES'] as $priceCode => $arPrice) {
							if (
								!in_array($priceCode, $arParams['FILTER_PRICE_CODE']) ||
								$arPrice['CAN_BUY'] !== 'Y' ||
								$arPrice['CAN_ACCESS'] !== 'Y'
							) {
								unset($arOffer['PRICES'][$priceCode]);
								continue;
							}
	
							$arPrice['MIN_PRICE'] = 'N';
	
							if (
								!$arOffer['MIN_PRICE'] ||
								$arOffer['MIN_PRICE']['DISCOUNT_VALUE'] > $arPrice['DISCOUNT_VALUE']
							) {
								$arOffer['MIN_PRICE'] =& $arOffer['PRICES'][$priceCode];
							}
						}
	
						if ($arOffer['MIN_PRICE']) {
							$arOffer['MIN_PRICE']['MIN_PRICE'] = 'Y';
						}
					}
				}
				
				if (!$arItem['OFFERS_SELECTED']) {
					if (
						$arOffer['SELECTED'] || 
						in_array($arOffer['ID'], $arParams['LIST_ITEM_ID']) ||
						in_array($arOffer['ID'], $arRealItemsIDs)
					) {
						$arOffer['SELECTED'] = true;
						$arItem['OFFERS_SELECTED'] = $offerIndex;
						$arItem['MIN_PRICE'] = $arOffer['MIN_PRICE'];

						if (!$arOffer['DETAIL_PAGE_URL']) {
							$dbRes = CIBlockElement::GetList(
								[],
								[
									'ID' => $arOffer['ID'],
									'IBLOCK_ID' => $arOffer['IBLOCK_ID'],
								],
								false,
								false, 
								[
									'ID',
									'IBLOCK_ID',
									'DETAIL_PAGE_URL',
								]
							);
							if ($arTmp = $dbRes->GetNext()) {
								$arOffer['DETAIL_PAGE_URL'] = $arTmp['DETAIL_PAGE_URL'];
							}
						}

						if ($arOffer['DETAIL_PAGE_URL']) {
							$arItem['DETAIL_PAGE_URL'] = $arOffer['DETAIL_PAGE_URL'];
						}
					}
					else {
						if (
							$arOffer['MIN_PRICE'] &&
							(
								!$arItem['MIN_PRICE'] ||
								$arItem['MIN_PRICE']['DISCOUNT_VALUE'] > $arOffer['MIN_PRICE']['DISCOUNT_VALUE']
							)
						) {
							$arItem['MIN_PRICE'] =& $arOffer['MIN_PRICE'];
						}
					}
				}
			}
			unset($arOffer);
		}
		else {
			if (
				$arParams['FILTER_PRICE_CODE'] &&
				is_array($arParams['FILTER_PRICE_CODE'])
			) {
				if ($arItem['PRICES']) {
					$arItem['MIN_PRICE'] = [];

					foreach ($arItem['PRICES'] as $priceCode => $arPrice) {
						if (
							!in_array($priceCode, $arParams['FILTER_PRICE_CODE']) ||
							$arPrice['CAN_BUY'] !== 'Y' ||
							$arPrice['CAN_ACCESS'] !== 'Y'
						) {
							unset($arItem['PRICES'][$priceCode]);
							continue;
						}
						
						$arPrice['MIN_PRICE'] = 'N';

						if (
							!$arItem['MIN_PRICE'] ||
							$arItem['MIN_PRICE']['DISCOUNT_VALUE'] > $arPrice['DISCOUNT_VALUE']
						) {
							$arItem['MIN_PRICE'] =& $arItem['PRICES'][$priceCode];
						}
					}

					if ($arItem['MIN_PRICE']) {
						$arItem['MIN_PRICE']['MIN_PRICE'] = 'Y';
					}
				}
			}
		}
	}
	unset($arItem);
}

foreach($arParams['LIST_ITEM_ID'] as $itemId)
{
	foreach($arResult['CATALOGS'] as $catalog)
	{
		$offersCatalogId = (int)$catalog['OFFERS_IBLOCK_ID'];
		$offersPropId = (int)$catalog['OFFERS_PROPERTY_ID'];
		$catalogId = (int)$catalog['IBLOCK_ID'];
		$sku = false;

		if($offersCatalogId > 0 && $offersPropId > 0)
			$sku = array("IBLOCK_ID" => $offersCatalogId, "SKU_PROPERTY_ID" => $offersPropId, "PRODUCT_IBLOCK_ID" => $catalogId);

		if (!empty($sku) && is_array($sku))
		{
			$skuPropList[$itemId] = array();
			$skuPropList[$itemId] = CIBlockPriceTools::getTreeProperties(
				$sku,
				$arParams['OFFER_TREE_PROPS'][$itemId],
				array(
					'PICT' => $emptyPreview,
					'NAME' => '-'
				)
			);

			$needValues = array();
			CIBlockPriceTools::getTreePropertyValues($skuPropList[$itemId], $needValues);

			foreach($skuPropList[$itemId] as $propertyCode => &$propertyValue)
			{
				if($propertyValue['SHOW_MODE'] == 'PICT')
				{
					$count = 0;
					foreach($propertyValue['VALUES'] as $key => &$value)
					{
						if(!in_array($value['XML_ID'], $arParams['PROPERTY_VALUE'][$itemId][$propertyCode]))
							unset($propertyValue['VALUES'][$key]);
						if(!empty($arParams['PROPERTY_ITERATION_VALUE'][$itemId][$propertyCode]))
						{
							foreach($arParams['PROPERTY_ITERATION_VALUE'][$itemId][$propertyCode] as $propValue)
							{
								if($propValue == $value['XML_ID'])
								{
									$value['ALLOCATION'] = true;
								}
							}
						}
						else
						{
							if(!$count)
								$value['ALLOCATION'] = true;
						}
					}
				}
				else
				{
					$count = 0;
					foreach($propertyValue['VALUES'] as $key => &$value)
					{
						if(isset($arParams['OFFER'][$itemId]))
						{
							if(in_array($value['NAME'], $arParams['PROPERTY_VALUE'][$itemId][$propertyCode]))
								$value['ALLOCATION'] = true;
							if(isset($value['NA']))
								unset($propertyValue['VALUES'][$key]);
						}
						else
						{
							if(!empty($arParams['PROPERTY_ITERATION_VALUE'][$itemId][$propertyCode]))
							{
								foreach($arParams['PROPERTY_ITERATION_VALUE'][$itemId][$propertyCode] as $propValue)
								{
									if($propValue == $value['NAME'])
									{
										$value['ALLOCATION'] = true;
									}
								}
							}
							else
							{
								if(!$count)
									$value['ALLOCATION'] = true;
							}
							if(!in_array($value['NAME'], $arParams['PROPERTY_VALUE'][$itemId][$propertyCode]))
								unset($propertyValue['VALUES'][$key]);
						}
						$count++;
					}
				}
			}
		}
	}
}

$arResult['SKU_PROPS'] = $skuPropList;
