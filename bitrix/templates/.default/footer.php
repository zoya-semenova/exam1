</main>

<footer id="footer" class="footer dark-background">

    <div class="footer-search">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-6">
                    <h4>Поиск</h4>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:search.title",
                        "",
                        array(
                            "NUM_CATEGORIES" => "1",
                            "TOP_COUNT" => "5",
                            "CHECK_DATES" => "N",
                            "SHOW_OTHERS" => "N",
                            "PAGE" => SITE_DIR."search/",
                            "CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
                            "SHOW_INPUT" => "Y",
                            "INPUT_ID" => "title-search-input",
                            "CONTAINER_ID" => "search",
                            "PRICE_CODE" => array(
                                0 => "BASE",
                            ),
                            "SHOW_PREVIEW" => "Y",
                            "PREVIEW_WIDTH" => "75",
                            "PREVIEW_HEIGHT" => "75",
                            "CONVERT_CURRENCY" => "Y"
                        ),
                        false
                    );?>
                </div>
            </div>
        </div>
    </div>



    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="index.html" class="d-flex align-items-center">
                    <span class="sitename">Компания</span>
                </a>
                <div class="footer-contact pt-3">
                    <p>111111 Москва</p>
                    <p>Улица, номер, офис</p>
                    <p class="mt-3"><strong>Телефон:</strong> <span>+7 000 000 00 00</span></p>
                    <p><strong>Email:</strong> <span>contact@company.ru</span></p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Полезные ссылки</h4>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "",
                    array(
                        "ROOT_MENU_TYPE" => "top",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600000",
                        "MENU_CACHE_USE_GROUPS" => "N",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                    ),
                    false,
                    array(
                        "HIDE_ICONS" => "N"
                    )
                );?>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Наши услуги</h4>
                <?$APPLICATION->IncludeComponent("bitrix:menu", "", array(
                    "ROOT_MENU_TYPE" => "bottom",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "1",
                    "USE_EXT" => "Y",
                    "ALLOW_MULTI_SELECT" => "N"
                ),
                    false,
                    array(
                        "ACTIVE_COMPONENT" => "Y"
                    )
                );?>
            </div>

            <div class="col-lg-4 col-md-12">
                <h4>Оставайтесь на связи</h4>
                <p>Мы рады видеть вас в наших соцсетях</p>
                <div class="social-links d-flex">
                    <a class="forimg" href="#"><img src="<?= DEFAULT_TEMPLATE_PATH?>/assets/img/ico/vk_w.svg"></a>
                </div>
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you've purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>

</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

</body>

</html>