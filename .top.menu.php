<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$aMenuLinks = Array(

    Array(
        "Портфолио",
        "portfolio/",
        Array(),
        Array(),
        ""
    ),
	Array(
		"О магазине", 
		"about/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Контакты",
		"contacts/",
		Array(),
		Array(),
		""
	),
	Array(
		"Мой кабинет",
		"personal/",
		Array(),
		Array(),
		"\$USER->IsAuthorized()"
	),
);
?>