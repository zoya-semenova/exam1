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
<?if ($arResult['ITEMS']):?>
	<?
	$title = $arParams["TITLE"] ?: Loc::getMessage("PRODUCTS_TITLE");
	$pathEmptyPreview = $urlFunc($this->GetFolder().'/images/no_photo.png');
	$arParams['NOTE'] = trim($arParams['NOTE']);
	$arParams['PAGE_ELEMENT_COUNT'] = intval($arParams['PAGE_ELEMENT_COUNT'] ?? 0);
	?>
	<div class="mail-wrapper-block mail-wrapper-block--products mail-wrapper-block" style="overflow: visible;position: relative;font-size: 16px;line-height: 22px;">
		<div class="mail-wrapper-block-title mail-wrapper-block-title--products-block" style="padding-bottom: 12px;font-size: 20px;line-height: 26px;font-weight: 400;"><?=$title?></div>

		<?if (strlen($arParams['NOTE'])):?>
			<div class="mail-wrapper-block-note mail-wrapper-block-note--products-block" style="padding-top: 8px;padding-bottom: 12px;"><?=$arParams['NOTE']?></div>
		<?endif;?>

		<div class="products-items" style="display: block;font-size: 0;">
			<?foreach (array_values($arResult['ITEMS']) as $i => $arItem):?>
				<?
				$url = $urlFunc($arItem['DETAIL_PAGE_URL']);

				$arItem['IMG_ID'] = $arItem["~PREVIEW_PICTURE"] ?: $arItem["~DETAIL_PICTURE"] ?: false;
				$arItem['IMGAGE'] = $arItem['IMG_ID'] ? CFile::ResizeImageGet($arItem['IMG_ID'], array('width' => 160, 'height' => 160), BX_RESIZE_IMAGE_PROPORTIONAL_ALT) : [];
				?>
				<div class="products-item<?=($i % 2 ? '' : ' products-item-odd')?>" style="<?=($i % 2 ? 'padding: 8px 0 8px 8px;' : 'padding: 8px 8px 8px 0;')?>box-sizing: border-box;width: 50%;display: inline-block;vertical-align: top;">
					<div class="mail-round-border" style="height: 100%;border: 1px solid #ededed;border-radius: 8px;overflow: hidden;">
						<div class="products-item-inner" style="padding: 24px;border-radius: 0;box-sizing: border-box;">
							<div class="products-item-img" style="width: 80px;height: 80px;margin: 0 0 18px 0;">
								<a href="<?=$url?>" style="text-decoration: none;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;">
									<?if ($arItem["~PREVIEW_PICTURE"]):?>
										<img src="<?=$urlFunc($arItem['IMGAGE']['src'])?>" alt="<?=htmlspecialcharsbx($arItem["NAME"])?>" title="<?=htmlspecialcharsbx($arItem["NAME"])?>" style="display: inline-block;vertical-align: middle;max-width: 100%;max-height: 100%;border: 0;margin: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" />
									<?else:?>
										<img src="<?=$pathEmptyPreview?>" alt="<?=htmlspecialcharsbx($arItem["NAME"])?>" title="<?=htmlspecialcharsbx($arItem["NAME"])?>" style="display: inline-block;vertical-align: middle;max-width: 100%;max-height: 100%;border: 0;margin: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" />
									<?endif;?>
								</a>
							</div>

							<div class="products-item-line" style="min-height: 25px;">
								<?if (
									$arItem["MIN_PRICE"] &&
									is_array($arItem["MIN_PRICE"])
								):?>
									<div class="products-item-price" style="font-size: 18px;line-height: 24px;color: #222222;white-space: nowrap;margin: 0 0 1px 0;display: inline-block;vertical-align: bottom;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arItem["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"])?></div>

									<?if (
										$arItem["MIN_PRICE"]["DISCOUNT_DIFF"] > 0 &&
										$arItem["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"] > 0
									):?>
										<div class="products-item-old-price" style="text-decoration: line-through;color: #555555;font-size: 12px;line-height: 18px;white-space: nowrap;margin: 0 0 1px 4px;display: inline-block;vertical-align: bottom;"><?=str_replace('&#8381;', Loc::getMessage('RUB'), $arItem["MIN_PRICE"]["PRINT_VALUE"])?></div>
									<?endif;?>
								<?endif;?>
							</div>

							<div class="products-item-name" style="font-size: 16px;line-height: 21px;height: 21px;display: -webkit-box;-webkit-line-clamp: 1;-webkit-box-orient: vertical;overflow: hidden;">
								<a href="<?=$url?>" style="text-decoration: none;<?=($arParams['BASE_COLOR'] ? 'color: '.$arParams['BASE_COLOR'].';' : '')?>-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;"><?=$arItem['NAME']?></a>
							</div>
						</div>
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
		
		<?if (
				$arParams['SHOW_BUTTON'] === 'Y' &&
				strlen($arParams['BUTTON_LINK'])
			):?>
			<?$buttonTitle = $arParams['BUTTON_TITLE'] ?: Loc::getMessage('BUTTON_TITLE_DEFAULT');?>
			<div class="block-button block-button--products" style="margin-top: 24px !important;<?=($arParams['BASE_COLOR'] ? 'background-color: '.$arParams['BASE_COLOR'].';' : '')?>border-radius: 7px;overflow: hidden;">
				<a title="<?=htmlspecialcharsbx($buttonTitle)?>" href="<?=$urlFunc($arParams['BUTTON_LINK'])?>" target="_blank" style="background: inherit;text-align: center;display: inline-block;width: 100%;line-height: 20px;color: #fff;text-decoration: none;font-size: 16px;min-height: 47px;padding: 13px 24px;vertical-align: middle;box-sizing: border-box;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;word-wrap: break-word;"><?=$buttonTitle?></a>
			</div>
		<?endif;?>
	</div>	
<?endif;?>