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

$title = $arParams["TITLE"] ?: Loc::getMessage("PRODUCTS_TITLE");
$pathEmptyPreview = $urlFunc($this->GetFolder().'/images/no_photo.png');
$arParams['NOTE'] = trim($arParams['NOTE']);
$arParams['PAGE_ELEMENT_COUNT'] = intval($arParams['PAGE_ELEMENT_COUNT'] ?? 0);
?>
<?if ($arResult['ITEMS']):?>
	<div class="mail-wrapper-block mail-wrapper-block--products" style="overflow: visible;position: relative;font-size: 16px;line-height: 22px;">
		<div class="mail-wrapper-block-title" style="font-size: 20px;line-height: 26px;font-weight: 400;padding-bottom: 20px;"><?=$title?></div>

		<?if (strlen($arParams['NOTE'])):?>
			<div class="mail-wrapper-block-note" style="padding-bottom: 20px;"><?=$arParams['NOTE']?></div>
		<?endif;?>

		<div class="mail-round-border" style="border: 1px solid #ededed;border-radius: 8px;overflow: hidden;">
			<div class="cart-items" style="padding: 0;min-width: 100%;table-layout: fixed;">
				<?foreach (array_values($arResult['ITEMS']) as $i => $arItem):?>
					<?
					$url = $urlFunc($arItem['DETAIL_PAGE_URL']);

					$arItem['IMG_ID'] = $arItem["~PREVIEW_PICTURE"] ?: $arItem["~DETAIL_PICTURE"] ?: false;
					$arItem['IMGAGE'] = $arItem['IMG_ID'] ? CFile::ResizeImageGet($arItem['IMG_ID'], array('width' => 160, 'height' => 160), BX_RESIZE_IMAGE_PROPORTIONAL_ALT) : [];
					?>
					<div class="cart-item<?=($i ? '' : ' cart-item--first')?>" style="<?=($i ? '' : 'border-top: none;')?>padding: 19px 23px;display: block;border-radius: 0;overflow: hidden;">
						<div class="cart-item-column cart-item-column--first" style="padding-top: 0;float: left;max-width: 265px;">
							<div class="cart-item-img" style="width: 75px;height: 75px;margin-right: 28px;float: left;">
								<a href="<?=$url?>" style="text-decoration: none;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;">
									<?if ($arItem["~PREVIEW_PICTURE"]):?>
										<img src="<?=$urlFunc($arItem['IMGAGE']['src'])?>" alt="<?=htmlspecialcharsbx($arItem["NAME"])?>" title="<?=htmlspecialcharsbx($arItem["NAME"])?>" style="display: inline-block;vertical-align: middle;max-width: 100%;max-height: 100%;border: 0;margin: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" />
									<?else:?>
										<img src="<?=$pathEmptyPreview?>" alt="<?=htmlspecialcharsbx($arItem["NAME"])?>" title="<?=htmlspecialcharsbx($arItem["NAME"])?>" style="display: inline-block;vertical-align: middle;max-width: 100%;max-height: 100%;border: 0;margin: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" />
									<?endif;?>
								</a>
							</div>

							<div class="cart-item-name cart-item-name--mobile" style="display: none;">
								<a href="<?=$url?>" style="text-decoration: none;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;"><?=$arItem['NAME']?></a>
							</div>
						</div>

						<div class="cart-item-column" style="padding-top: 3px;float: left;max-width: 265px;">
							<div class="cart-item-name cart-item-name--normal" style="display: block;margin-top: 1px;">
								<a href="<?=$url?>" style="text-decoration: none;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;"><?=$arItem['NAME']?></a>
							</div>

							<div class="cart-item-props" style="padding: 0;font-size: 14px;line-height: 18px;">
								<?if (
									$arItem["MIN_PRICE"] &&
									is_array($arItem["MIN_PRICE"]) &&
									$arItem["MIN_PRICE"]['PRICE_ID'] &&
									$arItem['CATALOG_GROUP_NAME_'.$arItem["MIN_PRICE"]['PRICE_ID']]
								):?>
									<div class="cart-item-prop" style="padding-top: 4px;">
										<span class="cart-item-prop-name" style="text-align: left;color: #999999;"><?=Loc::getMessage('SALE_TYPE')?>:</span>&nbsp;<span class="cart-item-prop-value" style="text-align: left;color: #555555;"><?=$arItem['CATALOG_GROUP_NAME_'.$arItem["MIN_PRICE"]['PRICE_ID']]?></span>
									</div>
								<?endif;?>

								<?if (
									$arResult['SKU_PROPS'] &&
									$arResult['SKU_PROPS'][$arItem['ID']] &&
									$arParams['PROPERTY_VALUE'] &&
									$arParams['PROPERTY_VALUE'][$arItem['ID']]
								):?>
									<?
									$arSkipPropCodes = ['ASSOCIATED_FILTER', 'EXPANDABLES_FILTER', 'PERIOD', 'TITLE_BUTTON', 'LINK_BUTTON', 'REDIRECT', 'LINK_PROJECTS', 'LINK_REVIEWS', 'DOCUMENTS', 'FORM_ORDER', 'FORM_QUESTION', 'PHOTOPOS', 'TASK_PROJECT', 'PHOTOS', 'LINK_COMPANY', 'GALLEY_BIG', 'LINK_SERVICES', 'LINK_GOODS', 'LINK_GOODS_FILTER', 'LINK_STAFF', 'LINK_SALE', 'LINK_FAQ', 'PRICE', 'PRICEOLD', 'LINK_NEWS', 'LINK_TIZERS', 'LINK_ARTICLES', 'LINK_STUDY', 'SEND_MESS', 'FORM_QUESTION_SIDE', 'INCLUDE_TEXT', 'POPUP_VIDEO', 'SHOW_ON_INDEX_PAGE', 'STATUS', 'ARTICLE', 'CML2_ARTICLE', 'ECONOMY', 'PRICE', 'PRICE_OLD', 'PRICE_CURRENCY', 'FILTER_PRICE', 'CODE_TEXT', 'BEST_ITEM', 'BNR_TOP', 'BNR_TOP_UNDER_HEADER', 'BNR_TOP_COLOR', 'MAIN_COLOR', 'BNR_TOP_IMG', 'BNR_TOP_BG', 'HIT', 'BLOG_POST_ID', 'BLOG_COMMENTS_CNT', 'VIDEO_IFRAME', 'SALE_NUMBER', 'H3_GOODS', 'FILTER_URL', 'ONLY_ONE_PRICE', 'ICON', 'BUTTON1TEXT', 'BUTTON1LINK', 'BUTTON1TARGET', 'BUTTON1CLASS', 'BUTTON1COLOR', 'BUTTON2TEXT', 'BUTTON2LINK', 'BUTTON2TARGET', 'BUTTON2CLASS', 'BUTTON2COLOR', 'VIDEO_YOUTUBE', 'MINIMUM_PRICE', 'MAXIMUM_PRICE', 'IN_STOCK', 'vote_count', 'vote_sum', 'rating', 'EXTENDED_REVIEWS_COUNT', 'EXTENDED_REVIEWS_RAITING', 'FORUM_TOPIC_ID', 'FORUM_MESSAGE_CNT', 'SALE_TEXT'];
									?>
									<?foreach ($arResult['SKU_PROPS'][$arItem['ID']] as $propCode => $arProperty):?>
										<?$propValue = $arParams['PROPERTY_VALUE'][$arItem['ID']][$propCode];?>
										<?if (
											$propValue ||
											strlen($propValue)
										):?>
											<?if (
												!in_array($propCode, $arSkipPropCodes) &&
												!in_array($arProperty['PROPERTY_TYPE'], ['E', 'F', 'G']) &&
												!in_array($arProperty['USER_TYPE'], ['Date', 'DateTime', 'video'])
											):?>
												<div class="cart-item-prop" style="padding-top: 4px;">
													<span class="cart-item-prop-name" style="text-align: left;color: #999999;"><?=$arResult['SKU_PROPS'][$arItem['ID']][$propCode]['NAME']?>:</span>&nbsp;
													<span class="cart-item-prop-value" style="text-align: left;color: #555555;"><?=(is_array($propValue) ? implode(', ', $propValue) : $propValue)?></span>
												</div>
											<?endif;?>
										<?endif;?>
									<?endforeach;?>
								<?endif;?>
							</div>
						</div>

						<div class="cart-item-column cart-item-column--last" style="text-align: right;padding-left: 28px;float: right;padding-top: 3px;max-width: 265px;">
							<?if (
								$arItem["MIN_PRICE"] &&
								is_array($arItem["MIN_PRICE"])
							):?>
								<div class="cart-item-sum" style="white-space: nowrap;margin-bottom: 1px;color: #222222;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arItem["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"])?></div>

								<?if (
									$arItem["MIN_PRICE"]["DISCOUNT_DIFF"] > 0 &&
									$arItem["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"] > 0
								):?>
									<div class="cart-item-old-sum" style="text-decoration: line-through;color: #555555;font-size: 12px;line-height: 18px;white-space: nowrap;margin-bottom: 4px;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arItem["MIN_PRICE"]["PRINT_VALUE"])?></div>
								<?endif;?>
							<?endif;?>
						</div>
					</div>
					<?
					if (
						$arParams['PAGE_ELEMENT_COUNT'] > 0 &&
						$i == ($arParams['PAGE_ELEMENT_COUNT'] - 1)
					) {
						break;
					}
					?>
				<?endforeach;?>
			</div>
		</div>
		
		<?if (
				$arParams['SHOW_BUTTON'] === 'Y' &&
				strlen($arParams['BUTTON_LINK'])
			):?>
			<?$buttonTitle = $arParams['BUTTON_TITLE'] ?: Loc::getMessage('BUTTON_TITLE_DEFAULT');?>
			<div class="block-button block-button--products" style="margin-top: 24px !important;background-<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>border-radius: 7px;overflow: hidden;">
				<a title="<?=htmlspecialcharsbx($buttonTitle)?>" href="<?=$urlFunc($arParams['BUTTON_LINK'])?>" target="_blank" style="background: inherit;text-align: center;display: inline-block;width: 100%;line-height: 20px;color: #fff;text-decoration: none;font-size: 16px;min-height: 47px;padding: 13px 24px;vertical-align: middle;box-sizing: border-box;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;"><?=$buttonTitle?></a>
			</div>
		<?endif;?>
	</div>	
<?endif;?>