<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
    <!-- Portfolio Sections -->
    <section class="portfolio-sections section">
        <div class="container">
            <div class="row gy-4">
<?
                foreach ($arResult['SECTIONS'] as &$arSection)
                {?>
                <div class="col-lg-6">
                    <div class="service-item position-relative">
                        <div class="img">
                            <img src="<? echo $arSection['PICTURE']['SRC']; ?>" class="img-fluid" alt="">
                        </div>
                        <div class="details">
                            <a href="<? echo $arSection["SECTION_PAGE_URL"]; ?>">
                                <? echo $arSection["NAME"];?>
                            </a>
                            <p>Примеры инженерных решений и разработанных проектов.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->
<?}?>

            </div>
        </div>
    </section><!-- /Portfolio Sections Section -->

