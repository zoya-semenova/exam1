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

?>
<?if (strlen($arResult['ERROR_MESSAGE'])):?>
	<div style="font-size: 14px;color: #c00;"><?=ShowError($arResult['ERROR_MESSAGE'])?></div>
<?else:?>
	<?
	$title = $arParams["TITLE"] ?: Loc::getMessage('ORDER_TITLE');
	$allCurrency = CSaleLang::GetLangCurrency($arParams['SITE_ID']);
	$pathEmptyPreview = $urlFunc($this->GetFolder().'/images/no_photo.png');
	$arParams['NOTE'] = trim($arParams['NOTE']);

	$bShowBase = $arParams['SHOW_ORDER_BASE'] === 'Y';
	$bShowUser = $arParams['SHOW_ORDER_USER'] === 'Y' && intval($arResult['USER_ID']);
	$bShowParams = $arParams['SHOW_ORDER_PARAMS'] === 'Y';
	$bShowBuyer = $arParams['SHOW_ORDER_BUYER'] === 'Y';
	$bShowPayment = $arParams['SHOW_ORDER_PAYMENT'] === 'Y';
	$bShowBasket = $arParams['SHOW_ORDER_BASKET'] === 'Y' && $arResult['BASKET'];

	$cntParts = (int)$bShowBase + (int)$bShowUser + (int)$bShowParams + (int)$bShowBuyer + (int)$bShowPayment + (int)$bShowBasket;
	$bShowPartSubtitle = $cntParts > 1;

	$orderTititle = Loc::getMessage('SPOD_ORDER_TITLE', array('#ORDER_NUMBER#' => $arResult['ACCOUNT_NUMBER'], '#ORDER_DATE#' => $arResult['DATE_INSERT_FORMATED']));
	?>
	<div class="mail-wrapper-block mail-wrapper-block--cart mail-wrapper-block--order" style="overflow: hidden;position: relative;font-size: 16px;line-height: 22px;">
		<div class="mail-wrapper-block-title" style="font-size: 20px;line-height: 26px;font-weight: 400;padding-bottom: 20px;"><?=($bShowPartSubtitle ? $orderTititle : $title)?></div>		

		<?if (strlen($arParams['NOTE'])):?>
			<div class="mail-wrapper-block-note" style="padding-bottom: 20px;"><?=$arParams['NOTE']?></div>
		<?endif;?>

		<?if ($bShowBase):?>
			<div class="mail-round-border" style="border: 1px solid #ededed;border-radius: 8px;overflow: hidden;">
				<div class="order-part-inner" style="padding: 6px 24px 24px;color: #999999;">
					<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width: 145px;padding-top: 18px;">
						<div><?=Loc::getMessage('SPOD_ORDER_STATUS')?></div>
						<div style="font-size:18px;color:#555555;font-weight:600;padding-top:5px;"><?=Loc::getMessage('SPOD_ORDER_DATE_FROM', array('#ORDER_DATE#' => $arResult['DATE_INSERT_FORMATED']))?></div>
					</div>

					<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width: 145px;padding-top: 18px;">
						<div><?=Loc::getMessage('SPOD_ORDER_SUMM')?></div>
						<div style="font-size:18px;color:#555555;font-weight:600;padding-top:5px;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arResult['PRICE_FORMATED'])?></div>
					</div>

					<?if (
						$arResult['CANCELED'] === 'Y' ||
						$arResult['CAN_CANCEL'] === 'Y'
					):?>
						<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width: 145px;padding-top: 18px;">
							<?if ($arResult['CANCELED'] === 'Y'):?>
								<div><?=Loc::getMessage('SPOD_ORDER_CANCELED')?></div>
								<div style="font-size:18px;color:#555555;font-weight:600;padding-top:5px;">
									<?=GetMessage('SPOD_YES')?> <?if(strlen($arResult['DATE_CANCELED_FORMATED'])):?><?=Loc::getMessage('SPOD_ORDER_DATE_FROM', array('#ORDER_DATE#' => $arResult['DATE_CANCELED_FORMATED']))?><?endif;?>
								</div>
							<?elseif ($arResult['CAN_CANCEL'] === 'Y'):?>
								<div style="font-size:18px;color:#555555;text-align:right;">
									<a href="<?=str_replace('ORDER_ID', $arResult['ACCOUNT_NUMBER'], $arResult['URL_TO_CANCEL'])?>" style="display:inline-block;font-size:14px;border-radius:3px;padding: 7px 24px;min-height: 35px;line-height:18px;border:1px solid;box-sizing: border-box;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>"><?=Loc::getMessage('SPOD_ORDER_CANCEL')?></a>
								</div>
							<?endif;?>
						</div>
					<?endif;?>
				</div>
			</div>
		<?endif;?>

		<?if ($bShowUser):?>
			<?if ($bShowPartSubtitle):?>
				<div class="mail-wrapper-block-subtitle" style="padding: 32px 0 20px;font-size: 20px;line-height: 26px;font-weight: 400;"><?=Loc::getMessage('SPOD_ACCOUNT_DATA')?></div>
			<?endif;?>

			<div class="mail-round-border" style="border: 1px solid #ededed;border-radius: 8px;overflow: hidden;">
				<div class="order-part-inner" style="padding: 6px 24px 24px;color: #999999;">
					<?if(strlen($arResult['USER_NAME'])):?>
						<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width: 145px;padding-top:18px;padding-right: 6px;box-sizing: border-box;">
							<div><?=Loc::getMessage('SPOD_ACCOUNT')?></div>
							<div style="font-size:14px;color:#555555;padding-top:5px;"><?=$arResult['USER_NAME']?></div>
						</div>
					<?endif;?>

					<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width: 145px;padding-top:18px;padding-right: 6px;box-sizing: border-box;">
						<div><?=Loc::getMessage('SPOD_LOGIN')?></div>
						<div style="font-size:14px;color:#555555;padding-top:5px;overflow: hidden;text-overflow: ellipsis;"><?=$arResult['USER']['LOGIN']?></div>
					</div>
					<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width: 145px;padding-top:18px;">
						<div><?=Loc::getMessage('SPOD_EMAIL')?></div>
						<div style="font-size:14px;color:#555555;padding-top:5px;"><a href="mailto:<?=$arResult['USER']['EMAIL']?>" style="text-decoration: none;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>word-wrap: break-word;"><?=$arResult['USER']['EMAIL']?></a></div>
					</div>
				</div>
			</div>
		<?endif;?>

		<?if ($bShowParams):?>
			<?if ($bShowPartSubtitle):?>
				<div class="mail-wrapper-block-subtitle" style="padding: 32px 0 20px;font-size: 20px;line-height: 26px;font-weight: 400;"><?=Loc::getMessage('SPOD_ORDER_PROPERTIES')?></div>
			<?endif;?>

			<div class="mail-round-border" style="border: 1px solid #ededed;border-radius: 8px;overflow: hidden;">
				<div class="order-part-inner" style="padding: 6px 24px 24px;color: #999999;">
					<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width:145px;padding-top:18px;">
						<div><?=Loc::getMessage('SPOD_ORDER_PERS_TYPE')?></div>
						<div style="font-size:14px;color:#555555;padding-top:5px;"><?=$arResult['PERSON_TYPE']['NAME']?></div>
					</div>
				</div>
			</div>
		<?endif;?>

		<?if ($bShowBuyer):?>
			<?if ($bShowPartSubtitle):?>
				<div class="mail-wrapper-block-subtitle" style="padding: 32px 0 20px;font-size: 20px;line-height: 26px;font-weight: 400;"><?=Loc::getMessage('SPOD_ORDER_UPROPERTIES')?></div>
			<?endif;?>

			<div class="mail-round-border" style="border: 1px solid #ededed;border-radius: 8px;overflow: hidden;">
				<div class="order-part-inner" style="padding: 6px 24px 24px;color: #999999;">
					<?foreach($arResult["ORDER_PROPS"] as $prop):?>
						<?
						if ($prop['TYPE'] !== 'CHECKBOX' && !$prop['VALUE']) {
							continue;
						}
						?>
						<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width:145px;padding-top:18px;padding-right: 6px;box-sizing: border-box;">
							<div><?=$prop['NAME']?>:</div>
							<div style="font-size:14px;color:#555555;padding-top:5px;overflow: hidden;text-overflow: ellipsis;">
								<?if($prop['TYPE'] === 'CHECKBOX'):?>
									<?=Loc::getMessage('SPOD_'.($prop['VALUE'] === 'Y' ? 'YES' : 'NO'))?>
								<?else:?>
									<?=$prop['VALUE']?>
								<?endif;?>
							</div>
						</div>
					<?endforeach;?>

					<?if(!empty($arResult['USER_DESCRIPTION'])):?>
						<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;padding-top:18px;">
							<div><?=Loc::getMessage('SPOD_ORDER_USER_COMMENT')?></div>
							<div style="font-size:14px;color:#555555;padding-top:5px;"><?=$arResult['USER_DESCRIPTION']?></div>
						</div>
					<?endif;?>
				</div>
			</div>
		<?endif;?>

		<?if ($bShowPayment):?>
			<?if ($bShowPartSubtitle):?>
				<div class="mail-wrapper-block-subtitle" style="padding: 32px 0 20px;font-size: 20px;line-height: 26px;font-weight: 400;"><?=Loc::getMessage('SPOD_ORDER_PAYMENT')?></div>
			<?endif;?>

			<div class="mail-round-border"style="border: 1px solid #ededed;border-radius: 8px;overflow: hidden;">
				<div class="order-part-inner" style="padding: 6px 24px 24px;color: #999999;">
					<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width:145px;padding-top:18px;padding-right: 6px;box-sizing: border-box;">
						<div><?=Loc::getMessage('SPOD_PAY_SYSTEM')?></div>
						<div style="font-size:14px;color:#555555;padding-top:5px;overflow: hidden;text-overflow: ellipsis;">
							<?if(intval($arResult['PAY_SYSTEM_ID'])):?>
								<?=$arResult['PAY_SYSTEM']['NAME']?>
							<?else:?>
								<?=Loc::getMessage('SPOD_NONE')?>
							<?endif;?>
						</div>
					</div>

					<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width:145px;padding-top:18px;padding-right: 6px;box-sizing: border-box;">
						<div><?=Loc::getMessage('SPOD_ORDER_PAYED')?></div>
						<div style="font-size:14px;color:#555555;padding-top:5px;overflow: hidden;text-overflow: ellipsis;">
							<?if($arResult["PAYED"] == "Y"):?>
								<?=Loc::getMessage('SPOD_YES')?><?if(strlen($arResult['DATE_PAYED_FORMATED'])):?><?=Loc::getMessage('SPOD_ORDER_DATE_FROM', array("#ORDER_DATE#" => $arResult['DATE_PAYED_FORMATED']))?><?endif;?>
							<?else:?>
								<?=Loc::getMessage('SPOD_NO')?>
							<?endif;?>
						</div>
					</div>

					<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width:145px;padding-top:18px;padding-right: 6px;box-sizing: border-box;">
						<div><?=Loc::getMessage('SPOD_ORDER_DELIVERY')?></div>
						<div style="font-size:14px;color:#555555;padding-top:5px;overflow: hidden;text-overflow: ellipsis;">
							<?if(strpos($arResult['DELIVERY_ID'], ":") !== false || intval($arResult['DELIVERY_ID'])):?>
								<?=$arResult['DELIVERY']['NAME']?>
							<?else:?>
								<?=Loc::getMessage('SPOD_NONE')?>
							<?endif;?>
						</div>
					</div>

					<?if($arResult['TRACKING_NUMBER']):?>
						<div style="display:inline-block;vertical-align:top;font-size:14px;width:100%;max-width:145px;padding-top:18px;">
							<div><?=Loc::getMessage('SPOD_ORDER_TRACKING_NUMBER')?></div>
							<div style="font-size:14px;color:#555555;padding-top:5px;"><?=$arResult['TRACKING_NUMBER']?></div>
						</div>
					<?endif;?>
				</div>
			</div>
		<?endif;?>

		<?if (
			$bShowBasket ||
			$arParams['SHOW_ORDER_SUM'] === 'Y'
		):?>
			<?if (
				$bShowBasket &&
				$bShowPartSubtitle
			):?>
				<div class="mail-wrapper-block-subtitle" style="padding: 32px 0 20px;font-size: 20px;line-height: 26px;font-weight: 400;"><?=Loc::getMessage('SPOD_ORDER_BASKET')?></div>
			<?endif;?>

			<div class="mail-round-border" style="border: 1px solid #ededed;border-radius: 8px;overflow: hidden;">
				<div class="cart-items" style="padding: 0;min-width: 100%;table-layout: fixed;">
					<?if ($bShowBasket):?>
						<?
						$arPriceGroups = [];

						$arHeadersIds = (array)$arParams['CUSTOM_SELECT_PROPS'];
						$arHeadersNames = array_map(function($id) {
							return Loc::getMessage('SPOD_HEADER_'.$id);
						}, $arHeadersIds);

						if (
							$arParams['CUSTOM_SELECT_PROPS'] &&
							is_array($arParams['CUSTOM_SELECT_PROPS'])
						) {
							foreach ((array)$arParams['CUSTOM_SELECT_PROPS'] as $i => $prop) {
								if ($prop !== 'PROPS' && strpos($prop, 'PROPERTY_') === false) {
									unset($arParams['CUSTOM_SELECT_PROPS'][$i]);
								}
							}
						}

						$sum = 0;
						?>
						<?foreach (array_values($arResult["BASKET"]) as $i => $arItem):?>
							<?
							$url = $urlFunc($arItem['DETAIL_PAGE_URL']);

							$arItem['PRICE'] = str_replace("-", "", $arItem['PRICE']);

							$arItem['IMG_ID'] = $arItem['PREVIEW_PICTURE'] ?: $arItem['DETAIL_PICTURE'] ?: false;
							$arItem['IMGAGE'] = $arItem['IMG_ID'] ? CFile::ResizeImageGet($arItem['IMG_ID'], array('width' => 150, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL_ALT) : [];
							?>
							<div class="cart-item<?=($i ? '' : ' cart-item--first')?>" style="<?=($i ? 'border-top: 1px solid #ededed;' : 'border-top: none;')?>padding: 19px 23px;display: block;border-radius: 0;overflow: hidden;">
								<div class="cart-item-column cart-item-column--first" style="padding-top: 0;float: left;max-width: 265px;">
									<?if (
										in_array('PICTURE', $arHeadersIds) ||
										in_array('PREVIEW_PICTURE', $arHeadersIds) ||
										in_array('DETAIL_PICTURE', $arHeadersIds)
									):?>
										<div class="cart-item-img" style="width: 75px;height: 75px;margin-right: 28px;float: left;">
											<a href="<?=$url?>" style="text-decoration: none;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;">
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

										<?if (
											($p = array_search('PROPS', (array)$arParams['CUSTOM_SELECT_PROPS'])) !== false &&
											is_array($arItem['PROPS']) && 
											$arItem['PROPS']
										):?>
											<?unset($arParams['CUSTOM_SELECT_PROPS'][$p])?>
											<?foreach ($arItem['PROPS'] as $prop):?>
												<div class="cart-item-prop" style="padding-top: 4px;">
													<span class="cart-item-prop-name" style="text-align: left;color: #999999;"><?=$prop['NAME']?>:</span>&nbsp;<span class="cart-item-prop-value" style="text-align: left;color: #555555;"><?=(is_array($prop['VALUE']) ? implode(', ', $prop['VALUE']) : $prop['VALUE'])?></span>
												</div>
											<?endforeach;?>
										<?endif;?>

										<?if ($arParams['CUSTOM_SELECT_PROPS']):?>
											<?foreach ((array)$arParams['CUSTOM_SELECT_PROPS'] as $propId):?>
												<?
												$headerName = Loc::getMessage('SPOD_'.$propId);
												
												if (!strlen($headerName)) {
													foreach (array_values($arResult['PROPERTY_DESCRIPTION']) as $prop_head_desc) {
														if (array_key_exists($propId, $prop_head_desc)) {
															$headerName = $prop_head_desc[$propId]['NAME'];
														}
													}
												}
												
												$value = $propId.'_VALUE';
												?>
												<?if ($arItem[$value]):?>
													<div class="cart-item-prop" style="padding-top: 4px;">
														<span class="cart-item-prop-name" style="text-align: left;color: #999999;"><?=$headerName?>:</span>&nbsp;<span class="cart-item-prop-value" style="text-align: left;color: #555555;"><?=(is_array($arItem[$value]) ? implode(', ', $arItem[$value]) : $arItem[$value])?></span>
													</div>
												<?endif;?>
											<?endforeach;?>
										<?endif;?>
									</div>

									<?if ($arParams['SHOW_REVIEW_BUTTON'] === 'Y'):?>
										<?$buttonText = $arParams['REVIEW_BUTTON_TITLE'] ?: Loc::getMessage('REVIEW_BUTTON_TITLE_DEFAULT')?>
										<div class="block-button block-button--cart-review block-button--cart-review--normal" style="margin: 12px 0 0;display: inline-block;<?=($arParams['BASE_COLOR'] ? 'background-color: '.$arParams['BASE_COLOR'].';' : '')?>border-radius: 7px;overflow: hidden;">
											<a title="<?=htmlspecialcharsbx($buttonText)?>" href="<?=$url.'#reviews'?>" target="_blank" style="background: inherit;line-height: 18px;font-size: 14px;min-height: 35px;padding: 7px 24px;width: 100%;text-align: center;display: inline-block;color: #fff;text-decoration: none;vertical-align: middle;box-sizing: border-box;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;"><?=$buttonText?></a>
										</div>
									<?endif;?>
								</div>

								<div class="cart-item-column cart-item-column--last" style="text-align: right;padding-left: 28px;float: right;padding-top: 3px;max-width: 265px;">
									<div class="cart-item-sum" style="white-space: nowrap;margin-bottom: 1px;color: #222222;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arItem['FORMATED_SUM'])?></div>
									
									<?if (
										$arItem['BASE_PRICE'] &&
										$arItem['BASE_PRICE'] != $arItem['PRICE']
									):?>
										<div class="cart-item-old-sum" style="text-decoration: line-through;color: #555555;font-size: 12px;line-height: 18px;white-space: nowrap;margin-bottom: 4px;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arItem['FORMATED_BASE_SUM'])?></div>
									<?endif;?>

									<?if (in_array('QUANTITY', $arHeadersIds)):?>
										<div class="cart-item-quantity" style="color: #222222;font-size: 12px;line-height: 18px;"><?=number_format($arItem['QUANTITY'], (is_float((string) $arItem['QUANTITY']) ? 2 : 0), '.', ' ')?>&nbsp;<?=$arItem['MEASURE_NAME']?></div>
									<?endif;?>

									<?if ($arParams['SHOW_REVIEW_BUTTON'] === 'Y'):?>
										<?$buttonText = $arParams['REVIEW_BUTTON_TITLE'] ?: Loc::getMessage('REVIEW_BUTTON_TITLE_DEFAULT')?>
										<div class="block-button block-button--cart-review block-button--cart-review--mobile" style="display: none;<?=($arParams['BASE_COLOR'] ? 'background-color: '.$arParams['BASE_COLOR'].';' : '')?>border-radius: 7px;overflow: hidden;">
											<a title="<?=htmlspecialcharsbx($buttonText)?>" href="<?=$url.'#reviews'?>" target="_blank" style="background: inherit;line-height: 18px;font-size: 14px;min-height: 35px;padding: 7px 24px;width: 100%;text-align: center;display: inline-block;color: #fff;text-decoration: none;vertical-align: middle;box-sizing: border-box;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;"><?=$buttonText?></a>
										</div>
									<?endif;?>
								</div>
							</div>
						<?endforeach;?>
					<?endif;?>

					<?if ($arParams['SHOW_ORDER_SUM'] === 'Y'):?>
						<div class="cart-item" style="border-top: 1px solid #ededed;padding: 19px 23px;display: block;border-radius: 0;overflow: hidden;">
							<div style="width: 100%;">
								<? ///// WEIGHT ?>
								<?if (in_array('WEIGHT_FORMATED', $arHeadersIds)):?>
									<?if (floatval($arResult['ORDER_WEIGHT'])):?>
										<div class="cart-item-itog" style="width: 100%;overflow: hidden;">
											<div class="cart-item-itog-label" style="display: inline-block;vertical-align: top;text-align: right;"><?=Loc::getMessage('SPOD_TOTAL_WEIGHT')?></div>
											<div class="cart-item-itog-sum" style="text-align: right;float: right;"><?=$arResult['ORDER_WEIGHT_FORMATED']?></div>
										</div>
									<?endif;?>
								<?endif;?>

								<?if ($arResult['PRODUCT_SUM'] != $arResult['PRICE']):?>
									<? ///// PRICE SUM ?>
									<div class="cart-item-itog" style="width: 100%;overflow: hidden;">
										<div class="cart-item-itog-label" style="display: inline-block;vertical-align: top;text-align: right;"><?=Loc::getMessage('SPOD_PRODUCT_SUM')?></div>
										<div class="cart-item-itog-sum" style="text-align: right;float: right;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arResult['PRODUCT_SUM_FORMATTED'])?></div>
									</div>

									<? ///// DELIVERY PRICE: print even equals 2 zero ?>
									<?if (strlen($arResult['PRICE_DELIVERY_FORMATED'])):?>
										<div class="cart-item-itog" style="width: 100%;overflow: hidden;">
											<div class="cart-item-itog-label" style="display: inline-block;vertical-align: top;text-align: right;"><?=Loc::getMessage('SPOD_DELIVERY')?></div>
											<div class="cart-item-itog-sum" style="text-align: right;float: right;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arResult['PRICE_DELIVERY_FORMATED'])?></div>
										</div>
									<?endif;?>
								<?endif;?>

								<? ///// TAXES DETAIL ?>
								<?foreach ($arResult['TAX_LIST'] as $tax):?>
									<div class="cart-item-itog" style="width: 100%;overflow: hidden;">
										<div class="cart-item-itog-label" style="display: inline-block;vertical-align: top;text-align: right;"><?=$tax["TAX_NAME"]?></div>
										<div class="cart-item-itog-sum" style="text-align: right;float: right;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $tax["VALUE_MONEY_FORMATED"])?></div>
									</div>
								<?endforeach;?>

								<? ///// TAX SUM ?>
								<?if (floatval($arResult['TAX_VALUE'])):?>
									<div class="cart-item-itog" style="width: 100%;overflow: hidden;">
										<div class="cart-item-itog-label" style="display: inline-block;vertical-align: top;text-align: right;"><?=Loc::getMessage('SPOD_TAX')?></div>
										<div class="cart-item-itog-sum" style="text-align: right;float: right;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arResult['TAX_VALUE_FORMATED'])?></div>
									</div>
								<?endif;?>

								<? ///// DISCOUNT ?>
								<?/*if (floatval($arResult['DISCOUNT_VALUE'])):?>
									<div class="cart-item-itog" style="width: 100%;overflow: hidden;">
										<div class="cart-item-itog-label" style="display: inline-block;vertical-align: top;text-align: right;"><?=Loc::getMessage('SPOD_DISCOUNT')?></div>
										<div class="cart-item-itog-sum" style="text-align: right;float: right;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arResult['DISCOUNT_VALUE_FORMATED'])?></div>
									</div>
								<?endif;*/?>

								<div class="cart-item-itog" style="width: 100%;overflow: hidden;">
									<div class="cart-item-itog-label" style="display: inline-block;vertical-align: top;text-align: right;"><?=Loc::getMessage('SPOD_SUMMARY')?></div>
									<div class="cart-item-itog-sum" style="text-align: right;float: right;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arResult['PRICE_FORMATED'])?></div>
								</div>
							</div>
						</div>
					<?endif;?>
				</div>
			</div>
		<?endif;?>
	</div>
<?endif;?>