<? if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

$arFilter = Array(
    "ACTIVE"        => "Y",
    "EVENT_NAME" => "CUSTOM_FORM"

);
$rsMess = CEventMessage::GetList($by="event_name", $order="desc", $arFilter);
$is_filtered = $rsMess->is_filtered;


$arComponentParameters = array(
    'PARAMETERS' => array(
        "ARRAY_FIELDS" => array(
            "NAME" => GetMessage("COMP_FORM_PARAMS_ARRAY_FIELDS"),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "N",
            "MULTIPLE" => "Y",
            //"SIZE" => "9",
            "VALUES" => array(
                "name",
                "email",
                "phone",
                "message",
            ),
        ),
        "ARRAY_FIELDS_REQUIRED" => array(
            "NAME" => GetMessage("COMP_FORM_PARAMS_ARRAY_FIELDS_REQUIRED"),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "N",
            "MULTIPLE" => "Y",
            //"SIZE" => "9",
            "VALUES" => array(
                "name",
                "email",
                "phone",
                "message",
            ),
        ),
        "EMAIL_TO" => array(
            "NAME" => GetMessage("COMP_FORM_PARAMS_EMAIL_TO"),
            "TYPE" => "STRING",
            "DEFAULT" => COption::GetOptionString("main", "email_from"),
        ),
        "NAME_TEMPLATE" => array(
            "NAME" => GetMessage("COMP_FORM_PARAMS_TEMPLATE"),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "N",
            "MULTIPLE" => "Y",
            //"SIZE" => "9",
            "VALUES" => $is_filtered,
        ),
        "VALIDATE_FIELDS" => array(
            "NAME" => GetMessage("COMP_FORM_PARAMS_VALIDATE_FIELDS"),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "N",
            "MULTIPLE" => "Y",
            //"SIZE" => "9",
            "VALUES" => array(
                "name" => "name",
                "email" => "email",
            ),
        ),
        "TITLE_FORM" => array(
            "NAME" => GetMessage("COMP_FORM_PARAMS_TITLE_FORM"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "TEXT_MESSAGE" => array(
            "NAME" => GetMessage("COMP_FORM_PARAMS_TEXT_MESSAGE"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "USE_CAPTCHA" => array(
            "NAME" => GetMessage("COMP_FORM_PARAMS_USE_CAPTCHA"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "SEND_EMAIL_USER" => array(
            "NAME" => GetMessage("COMP_FORM_PARAMS_SEND_EMAIL_USER"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
    ),
);


?>
