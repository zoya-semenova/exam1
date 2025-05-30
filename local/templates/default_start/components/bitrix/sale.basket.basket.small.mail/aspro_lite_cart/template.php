<?
use Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

Loader::includeModule('sale');
Loader::includeModule('currency');
Loader::includeModule('catalog');

$urlFunc = function($url = '') use ($arParams) :string  {
	if (
		strpos($url, 'http:') === false &&
		strpos($url, 'https:') === false
	) {
		$url = str_replace(array("//", ":/"), array("/", "://"), $arParams['SITE_ADDRESS'].$url);
	}

	return $url;
};

if (
	$arResult["ShowReady"] == "Y" ||
	$arResult["ShowDelay"] == "Y" ||
	$arResult["ShowSubscribe"] == "Y" ||
	$arResult["ShowNotAvail"] == "Y"
) {
	$arPriceGroups = [];
	$arParams['NOTE'] = trim($arParams['NOTE']);
	
	$arHeaders = array("NAME", "DISCOUNT", "QUANTITY", "SUMM");

	foreach ($arResult['GRID']['HEADERS'] as $id => $arHeader) {
		$arHeader["name"] = (isset($arHeader["name"]) ? (string)$arHeader["name"] : '');

		if ($arHeader["name"] == '') {
			$arResult['GRID']['HEADERS'][$id]["name"] = Loc::getMessage("SALE_".$arHeader["id"]);
			if(strlen($arResult['GRID']['HEADERS'][$id]["name"])==0) {
				$arResult['GRID']['HEADERS'][$id]["name"] = Loc::getMessage("SALE_".str_replace("_FORMATED", "", $arHeader["id"]));
			}
		}
	}

	$title = $arParams["TITLE"] ?: Loc::getMessage("BASKET_TITLE");
	$allCurrency = CSaleLang::GetLangCurrency($arParams["SITE_ID"]);
	$pathEmptyPreview = $urlFunc($this->GetFolder().'/images/no_photo.png');
	$summ = 0;

	$arGroups = [];
	if (
		$arResult["ShowReady"] === "Y" &&
		$arResult["ITEMS"]["AnDelCanBuy"]
	) {
		$arGroups[] = [
			'TITLE' => '',
			'ITEMS' => $arResult["ITEMS"]["AnDelCanBuy"],
		];
	}
	if (
		$arResult["ShowDelay"] === "Y" &&
		$arResult["ITEMS"]["DelDelCanBuy"]
	) {
		$arGroups[] = [
			'TITLE' => Loc::getMessage("TSBS_DELAY"),
			'ITEMS' => $arResult["ITEMS"]["DelDelCanBuy"],
		];
	}
	if (
		$arResult["ShowSubscribe"] === "Y" &&
		$arResult["ITEMS"]["ProdSubscribe"]
	) {
		$arGroups[] = [
			'TITLE' => Loc::getMessage("TSBS_SUBSCRIBE"),
			'ITEMS' => $arResult["ITEMS"]["ProdSubscribe"],
		];
	}
	if (
		$arResult["ShowNotAvail"] === "Y" &&
		$arResult["ITEMS"]["nAnCanBuy"]
	) {
		$arGroups[] = [
			'TITLE' => Loc::getMessage("TSBS_UNAVAIL"),
			'ITEMS' => $arResult["ITEMS"]["nAnCanBuy"],
		];
	}
	
	if ($arGroups) {
		$arHeadersIds = array_column($arResult['GRID']['HEADERS'], 'id');
		$arHeadersNames = array_column($arResult['GRID']['HEADERS'], 'name');
		?>
		<div class="mail-wrapper-block mail-wrapper-block--cart" style="overflow: hidden;position: relative;font-size: 16px;line-height: 22px;">
			<div class="mail-wrapper-block-title" style="font-size: 20px;line-height: 26px;font-weight: 400;padding-bottom: 20px;"><?=$title?></div>

			<?foreach ($arGroups as $arGroup):?>
				<?if ($arGroup['TITLE']):?>
					<div class="mail-wrapper-block-subtitle" style="padding: 32px 0 20px;font-size: 20px;line-height: 26px;font-weight: 400;"><?=$arGroup['TITLE']?></div>
				<?endif;?>

				<?if (strlen($arParams['NOTE'])):?>
					<div class="mail-wrapper-block-note" style="padding-bottom: 20px;"><?=$arParams['NOTE']?></div>
				<?endif;?>

				<div class="mail-round-border" style="border: 1px solid #ededed;border-radius: 8px;overflow: hidden;">
					<div class="cart-items" style="padding: 0;min-width: 100%;table-layout: fixed;">
						<?
						$sum = 0;
						?>

						<?foreach (array_values($arGroup['ITEMS']) as $i => $arItem):?>
							<?
							$url = $urlFunc($arItem['~DETAIL_PAGE_URL']); // ~ with oid for offers!

							$sum += $arItem['SUM_FULL_PRICE'];

							$arItem['IMG_ID'] = $arItem["PREVIEW_PICTURE"] ?: $arItem["DETAIL_PICTURE"] ?: false;
							$arItem['IMGAGE'] = $arItem['IMG_ID'] ? CFile::ResizeImageGet($arItem['IMG_ID'], array('width' => 150, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL_ALT) : [];
							?>
							<div class="cart-item<?=($i ? '' : ' cart-item--first')?>" style="<?=($i ? 'border-top: 1px solid #ededed;' : 'border-top: none;')?>padding: 19px 23px;display: block;border-radius: 0;overflow: hidden;">
								<div class="cart-item-column cart-item-column--first" style="padding-top: 0;float: left;max-width: 265px;">
									<?if (
										in_array('PREVIEW_PICTURE', $arHeadersIds) ||
										in_array('DETAIL_PICTURE', $arHeadersIds)
									):?>
										<div class="cart-item-img" style="width: 75px;height: 75px;margin-right: 28px;float: left;">
											<a href="<?=$url?>" style="text-decoration: none;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>word-wrap: break-word;">
												<?if($arItem['IMGAGE']):?>
													<img src="<?=$urlFunc($arItem['IMGAGE']['src'])?>" alt="<?=htmlspecialcharsbx($arItem['NAME'])?>" title="<?=htmlspecialcharsbx($arItem['NAME'])?>" style="display: inline-block;vertical-align: middle;max-width: 100%;max-height: 100%;border: 0;margin: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" />
												<?else:?>
													<img src="<?=$pathEmptyPreview?>" alt="<?=htmlspecialcharsbx($arItem['NAME'])?>" title="<?=htmlspecialcharsbx($arItem['NAME'])?>" style="display: inline-block;vertical-align: middle;max-width: 100%;max-height: 100%;border: 0;margin: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" />
												<?endif;?>
											</a>
										</div>
									<?endif;?>

									<?if (in_array('NAME', $arHeadersIds)):?>
										<div class="cart-item-name cart-item-name--mobile" style="display: none;">
											<a href="<?=$url?>" style="text-decoration: none;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;"><?=$arItem['NAME']?></a>
										</div>
									<?endif;?>
								</div>

								<div class="cart-item-column" style="padding-top: 3px;float: left;max-width: 265px;">
									<?if (in_array('NAME', $arHeadersIds)):?>
										<div class="cart-item-name cart-item-name--normal" style="display: block;margin-top: 1px;">
											<a href="<?=$url?>" style="text-decoration: none;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;"><?=$arItem['NAME']?></a>
										</div>
									<?endif;?>

									<div class="cart-item-props" style="padding: 0;font-size: 14px;line-height: 18px;">
										<?if (
											$arItem['PRICE_TYPE_ID'] &&
											($p = array_search('TYPE', $arHeadersIds)) !== false
										):?>
											<?
											if (!isset($arPriceGroups[$arItem['PRICE_TYPE_ID']])) {
												$arPriceGroups[$arItem['PRICE_TYPE_ID']] = CCatalogGroup::GetByID($arItem['PRICE_TYPE_ID']);
											}

											$arPriceGroup = $arPriceGroups[$arItem['PRICE_TYPE_ID']];
											?>
											<div class="cart-item-prop" style="padding-top: 4px;">
												<span class="cart-item-prop-name" style="text-align: left;color: #999999;"><?=$arHeadersNames[$p]?>:</span>&nbsp;<span class="cart-item-prop-value" style="text-align: left;color: #555555;"><?=$arPriceGroup['NAME_LANG']?></span>
											</div>
										<?endif;?>

										<?foreach($arResult['GRID']['HEADERS'] as $id => $arHeader):?>
											<?if(
												strlen($arHeader['name']) &&
												isset($arItem[$arHeader['id']]) &&
												!empty($arItem[$arHeader['id']]) &&
												preg_match('/^PROPERTY_/', $arHeader['id'])
											):?>
												<div class="cart-item-prop" style="padding-top: 4px;">
													<span class="cart-item-prop-name" style="text-align: left;color: #999999;"><?=$arHeader['name']?>:</span>&nbsp;<span class="cart-item-prop-value" style="text-align: left;color: #555555;"><?=(is_array($arItem[$arHeader['id']]) ? implode(', ', $arItem[$arHeader['id']]) : $arItem[$arHeader['id']])?></span>
												</div>
											<?endif;?>
										<?endforeach;?>
									</div>
								</div>

								<div class="cart-item-column cart-item-column--last" style="text-align: right;padding-left: 28px;float: right;padding-top: 3px;max-width: 265px;">
									<?if (in_array('SUM', $arHeadersIds)):?>
										<div class="cart-item-sum" style="white-space: nowrap;margin-bottom: 1px;color: #222222;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arItem['SUM'])?></div>

										<?if (
											$arItem['SUM_FULL_PRICE'] &&
											$arItem['SUM_FULL_PRICE'] != $arItem['SUM_VALUE']
										):?>
											<div class="cart-item-old-sum" style="text-decoration: line-through;color: #555555;font-size: 12px;line-height: 18px;white-space: nowrap;margin-bottom: 4px;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arItem['SUM_FULL_PRICE_FORMATED'])?></div>
										<?endif;?>
									<?endif;?>

									<?if (in_array('QUANTITY_FORMATED', $arHeadersIds)):?>
										<div class="cart-item-quantity" style="color: #222222;font-size: 12px;line-height: 18px;"><?=number_format($arItem['QUANTITY'], (is_float((string) $arItem['QUANTITY']) ? 2 : 0), '.', ' ')?>&nbsp;<?=$arItem['MEASURE_NAME']?></div>
									<?endif;?>
								</div>
							</div>
						<?endforeach;?>

						<?if (!strlen($arGroup['TITLE'])):?>
							<div class="cart-item" style="border-top: 1px solid #ededed;padding: 19px 23px;display: block;border-radius: 0;overflow: hidden;">
								<div class="cart-item-itog" style="width: 100%;overflow: hidden;">
									<div class="cart-item-itog-label" style="display: inline-block;vertical-align: top;text-align: right;"><?=Loc::getMessage('SUM')?></div>
									<div class="cart-item-itog-sum" style="text-align: right;float: right;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), CCurrencyLang::CurrencyFormat($sum, $allCurrency))?></div>
								</div>
							</div>
						<?endif;?>
					</div>
				</div>
			<?endforeach;?>

			<?if (
				$arParams['SHOW_BUTTON'] === 'Y' &&
				strlen($arParams['BUTTON_LINK'])
			):?>
				<?$buttonTitle = $arParams['BUTTON_TITLE'] ?: Loc::getMessage('BUTTON_TITLE_DEFAULT');?>
				<div class="block-button block-button--cart" style="<?=($arParams['BASE_COLOR'] ? 'background-color: '.$arParams['BASE_COLOR'].';' : '')?>border-radius: 7px;overflow: hidden;">
					<a title="<?=htmlspecialcharsbx($buttonTitle)?>" href="<?=$urlFunc($arParams['BUTTON_LINK'])?>" target="_blank" style="background: inherit;text-align: center;display: inline-block;width: 100%;line-height: 20px;color: #fff;text-decoration: none;font-size: 16px;min-height: 47px;padding: 13px 24px;vertical-align: middle;box-sizing: border-box;word-wrap: break-word;"><?=$buttonTitle?></a>
				</div>
			<?endif;?>
		</div>
		<?
	}
}