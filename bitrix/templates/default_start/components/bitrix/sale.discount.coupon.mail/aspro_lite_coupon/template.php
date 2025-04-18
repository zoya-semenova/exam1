<?
use Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc,
	Aspro\Functions\CAsproLite as SolutionFunctions;

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

$hex2RgbFunc = function($color = '', $opacity = 1.0) :string {
	$hex = str_replace('#', '', $color);
	if (strlen($hex) == 3) {
		$hex .= $hex;
	}

	$result = '#'.$hex;

	if (function_exists('hexdec')) {
		$split_hex = str_split($hex, 2);
		$result = 'rgba('.hexdec($split_hex[0]).','.hexdec($split_hex[1]).','.hexdec($split_hex[2]).','.strval($opacity).')';
	}

	return $result;
};

$title = $arParams['TITLE'] ?: Loc::getMessage('COUPON_TITLE');
?>
<div class="mail-wrapper-block mail-wrapper-block--coupon" style="overflow: hidden;position: relative;font-size: 16px;line-height: 22px;">
	<div class="coupon-block" style="margin: 0 0 16px;text-align: center;min-height: 47px;display: block;padding: 13px 24px;<?=($arParams['BASE_COLOR'] ? 'background-color: '.$hex2RgbFunc($arParams['BASE_COLOR'], '0.1').';' : '')?>border-radius: 7px;overflow: hidden;box-sizing: border-box;">
		<span class="coupon-title" style="text-align: left;font-size: 16px;line-height: 20px;color: #222222;text-decoration: none;position: relative;"><?=$title?></span>&nbsp;
		<span class="coupon-value" style="text-align: left;font-size: 16px;line-height: 20px;color: #222222;font-weight: 600;position: relative;white-space: nowrap;"><?=$arResult['COUPON']?></span>
	</div>

	<?if (
		$arParams['SHOW_BUTTON'] === 'Y' &&
		strlen($arParams['BUTTON_LINK'])
	):?>
		<?$buttonTitle = $arParams['BUTTON_TITLE'] ?: Loc::getMessage('BUTTON_TITLE_DEFAULT');?>
		<div class="block-button block-button--coupon" style="margin: 0 0 16px;<?=($arParams['BASE_COLOR'] ? 'background-color: '.$arParams['BASE_COLOR'].';' : '')?>border-radius: 7px;overflow: hidden;">
			<a title="<?=htmlspecialcharsbx($buttonTitle)?>" href="<?=$urlFunc($arItem['BUTTON_LINK'])?>" target="_blank" style="background:inherit" style="background: inherit;text-align: center;display: inline-block;width: 100%;line-height: 20px;color: #fff;text-decoration: none;font-size: 16px;min-height: 47px;padding: 13px 24px;vertical-align: middle;box-sizing: border-box;word-wrap: break-word;"><?=$buttonTitle?></a>
		</div>
	<?endif;?>

	<?if (
		$arParams['COUPON_IS_LIMITED'] === 'Y' &&
		(int)$arParams['COUPON_LIMIT_VALUE'] >= 0 &&
		in_array($arParams['COUPON_LIMIT_TYPE'], ['days', 'weeks', 'months'])
	):?>
		<div class="coupon-limit" style="font-size: 14px;line-height: 22px;color: #555555;margin-top: 4px;text-align: center;">
			<?=Loc::getMessage(
				'COUPON_LIMIT', [
					'#LIMIT#' => SolutionFunctions::declOfNum(
						(int)$arParams['COUPON_LIMIT_VALUE'], (
							$arParams['COUPON_LIMIT_TYPE'] === 'days' ? [
								Loc::getMessage('COUPON_LIMIT_DAY1'),
								Loc::getMessage('COUPON_LIMIT_DAY2'),
								Loc::getMessage('COUPON_LIMIT_DAY0'),
							] : ($arParams['COUPON_LIMIT_TYPE'] === 'weeks' ? [
								Loc::getMessage('COUPON_LIMIT_WEEK1'),
								Loc::getMessage('COUPON_LIMIT_WEEK2'),
								Loc::getMessage('COUPON_LIMIT_WEEK0'),
							] : [
								Loc::getMessage('COUPON_LIMIT_MONTH1'),
								Loc::getMessage('COUPON_LIMIT_MONTH2'),
								Loc::getMessage('COUPON_LIMIT_MONTH0'),
							])
						)
					)
				]
			);?>
		</div>
	<?endif;?>
</div>