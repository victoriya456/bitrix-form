<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Демонстрационная версия продукта «1С-Битрикс: Управление сайтом»");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Каталог книг");
?> <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"",
	Array(
		"IBLOCK_TYPE" => "books",
		"IBLOCK_ID" => "6",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_URL" => "/e-store/books/#SECTION_ID#/",
		"COUNT_ELEMENTS" => "Y",
		"DISPLAY_PANEL" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	)
);?>
<hr />

<?$APPLICATION->IncludeComponent(
	"res:form",
	"form1",
	Array(
		"FORM_ID" => "rs2",
		"FORM_TITLE" => "action1",
		"FIELD_LABEL" => array(
			"name" => "Имя",
			"email" => "Email",
			"phone" => "Телефон",
			"message" => "Сообщение",
		),
		"FIELDS_VALIDATE" => array(
			"required" => array(
				"name",
				"email",
				"phone",
				"message",
			),
			"email" => array(
				"email",
			),
			"lengthMax" => array(
				"name",
				"PARAMETRS" => "10",
				
			),
			"lengthMin" => array(
				"name",
				"PARAMETRS" => "3",
			),
		),
		"MESSAGE_SUCCESS" => "SUCCESS",

		"EVENT_MESSAGE_ID" => "121",

		"EMAIL_TO" => "vv@ff.vob",
		"ID_LETTER_TEMPLATE" => "44",

		"SEND_EMAIL_USER" => "Y",
		"ID_LETTER_TEMPLATE_USER" => "45",

		"USE_CAPTCHA" => "Y",

		"AJAX_MODE" => "N",
		"AJAX_OPTION_SHADOW" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"PATH_LANG_FILES_SITE_TEMPLATE" => "Y",
		"PATH_LANG_FILES_LOCAL_DIR" => "N",

	)
);
?>

<?$APPLICATION->IncludeComponent("res:form", "template1", Array(
		"FORM_ID" => "rs1",
	
		"SAVE_RESULT_IN_INFOBLOCK" => "Y",
		"IBLOCK_ID" => "16",
		"FORM_TITLE" => "action",
		"FIELDS" => array(
			"name" => "STRING",
			"email" => "STRING",
			"phone" => "STRING",
			"message" => "HTML",
		),
		"IBLOCK_NAME_ITREM" => "name",
		"FIELD_LABEL" => array(
				"name" => "Имя",
				"email" => "Email",
				"phone" => "Телефон",
				"message" => "Сообщение",
		),
		"FIELDS_VALIDATE" => array(
			"required" => array(
				"name",
				"email",
				"phone",
				"message",
			),
			"email" => array(
				"email",
			),
		),
		"MESSAGE_SUCCESS" => "SUCCESS",

		"EVENT_MESSAGE_ID" => "121",

		"EMAIL_TO" => "vv@ff.vob",
		"ID_LETTER_TEMPLATE" => "44",
	
		"SEND_EMAIL_USER" => "Y",
		"ID_LETTER_TEMPLATE_USER" => "45",

		"USE_CAPTCHA" => "N",

		"AJAX_MODE" => "Y",
		"AJAX_OPTION_SHADOW" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"PATH_LANG_FILES_SITE_TEMPLATE" => "Y",
		"PATH_LANG_FILES_LOCAL_DIR" => "N",

	),
	false
);
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>