<div class="col-lg-4">

    <div class="service-box">

        <?$APPLICATION->IncludeComponent(
            "bitrix:menu",
            "left",
            array(
                "ROOT_MENU_TYPE" => "left",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_TIME" => "3600000",
                "MENU_CACHE_USE_GROUPS" => "N",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "MAX_LEVEL" => "1",
                "USE_EXT" => "N",
                "DELAY" => "N",
            ),
            false,
            array(
                "HIDE_ICONS" => "N"
            )
        );?>
    </div>

    <div class="service-box">
        <h4>Материалы</h4>
        <div class="download-catalog">
            <a href="#"><i class="bi bi-filetype-pdf"></i><span>Скачать PDF</span></a>
            <a href="#"><i class="bi bi-file-earmark-word"></i><span>Скачать DOC</span></a>
        </div>
    </div>

    <div class="help-box d-flex flex-column justify-content-center align-items-center">
        <i class="bi bi-headset help-icon"></i>
        <h4>Вопросы?</h4>
        <p class="d-flex align-items-center mt-2 mb-0"><i class="bi bi-telephone me-2"></i> <span>+7 000
									000 00 00</span></p>
        <p class="d-flex align-items-center mt-1 mb-0"><i class="bi bi-envelope me-2"></i> <a
                href="mailto:contact@example.com">contact@company.ru</a></p>
    </div>

</div>