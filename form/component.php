<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*
 * Параметры компонента
 * FORM_ID - id формы
 * FIELDS_VALIDATE - какие правила валидации применить к полям https://github.com/vlucas/valitron
 * SAVE_RESULT_IN_INFOBLOCK - сохрать результаты в инфоблок
 * IBLOCK_ID - если да, id созданного инфоблока
 * FORM_TITLE - заголовок формы
 * FIELDS - перечисление полей какие нужно сохранить (имя поля => тип поля)
 * MESSAGE_SUCCESS - сообщение об удачной отправки
 * EVENT_MESSAGE_ID - id почтовое событие
 * EMAIL_TO - на какой email отправлять
 * ID_LETTER_TEMPLATE - почтовый шаблон письма админу
 * SEND_EMAIL_USER - отправлять ли письмо пользователю
 * ID_LETTER_TEMPLATE_USER - почтовый шаблон письма пользователю
 * USE_CAPTCHA - использовать капчу
 * AJAX_MODE - ajax режим
 * */

$error_message = array();
$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());
if($arParams["USE_CAPTCHA"] == "Y"){
    $arResult["captcha"]=$APPLICATION->CaptchaGetCode();
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"])) {
    if(check_bitrix_sessid()) {

        if (!empty($_POST["WEB_FORM_ID"])) {

            Validator::lang(LANGUAGE_ID);


            if(isset($arParams["PUTH_LANG_FILES_SITE_TEMPLATE"]) && $arParams["PUTH_LANG_FILES_SITE_TEMPLATE"] == "Y"){
                $puth_lang_files = $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/components/res/form/" . $componentTemplate . "/lang";
            }else if(isset($arParams["PUTH_LANG_FILES_LOCAL_DIR"]) && $arParams["PUTH_LANG_FILES_LOCAL_DIR"] == "Y"){
                $puth_lang_files = $_SERVER["DOCUMENT_ROOT"] . "/local/components/res/form/templates/" . $componentTemplate . "/lang";
            }else if(isset($arParams["PUTH_LANG_FILES_TEMPLATE_COMPONENT"]) && $arParams["PUTH_LANG_FILES_TEMPLATE_COMPONENT"] == "Y"){
                $puth_lang_files = $_SERVER["DOCUMENT_ROOT"] .  "/bitrix/components/res/form/" . $componentTemplate . "/lang";
            }

            Validator::langDir($puth_lang_files);
            $v = new  Validator($_POST);

            foreach ($arParams["FIELDS_VALIDATE"] as $rule => $names_fields) {
                if (isset($names_fields["PARAMETRS"]) && !empty($names_fields["PARAMETRS"])) {
                    $v->rule($rule, $names_fields, $names_fields["PARAMETRS"]);
                } else {
                    $v->rule($rule, $names_fields);
                }
            }
            if(isset($arParams["FIELD_LABEL"]) && !empty($arParams["FIELD_LABEL"])){
                $v->labels($arParams["FIELD_LABEL"]);
            }
            if (!$v->validate()) {
                // Errors
                $error_message = $v->errors();
            }


            if ($arParams["USE_CAPTCHA"] == "Y") {
                if (!$APPLICATION->CaptchaCheckCode($_POST["captcha_word"], $_POST["captcha_sid"])) {
                    $error_message["captcha"] = "wrong captcha code";
                }
            }

            $arResult["error_message"] = $error_message;

            //отправить email
            if (empty($arResult["error_message"])) {
                $form_requests = $_POST;

                if (empty($arParams["EMAIL_TO"])) {
                    $arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
                }
                $arMailFields = Array();
                $arMailFields["EMAIL_TO"] = $arParams["EMAIL_TO"];

                foreach ($form_requests as $name_field => $field) {
                    $arMailFields[strtoupper($name_field)] = $field;
                }

                CEvent::Send($arParams["EVENT_MESSAGE_ID"], SITE_ID, $arMailFields, "Y", $arParams["ID_LETTER_TEMPLATE"]);
                
                //отправить email пользователю
                if ($arParams["SEND_EMAIL_USER"] == "Y") {
                    if (!empty($form_requests["email"])) {
                        $arMailFields["EMAIL_TO"] = $form_requests["email"];
                        CEvent::Send($arParams["EVENT_MESSAGE_ID"], SITE_ID, $arMailFields, "Y", $arParams["ID_LETTER_TEMPLATE_USER"]);
                    } else {
                        // Сохраним в лог сообщение
                        AddMessage2Log("not send_email_user!!", "res:form");
                    }
                }
                if (empty($arParams["MESSAGE_SUCCESS"])) {
                    $arParams["MESSAGE_SUCCESS"] = "Message send!";
                }
                $arResult["success"] = $arParams["MESSAGE_SUCCESS"];

                //сохранить резльтаты в инфоблок
                if($arParams["SAVE_RESULT_IN_INFOBLOCK"] == "Y" && isset($arParams['IBLOCK_ID']) && !empty($arParams['IBLOCK_ID'])){
                    if(!CModule::IncludeModule("iblock")){
                        ShowError(GetMessage("CC_BIEAF_IBLOCK_MODULE_NOT_INSTALLED"));
                        return;
                    }
                    $element = new ComponentFormElement($arParams["IBLOCK_ID"], $arParams["FIELDS"], $form_requests, $form_requests['name']);
                    $element->SaveElement();
                }

            } else {
                // Сохраним в лог сообщение
                AddMessage2Log("not send_email!", "res:form");
            }
        }
    }
}
$this->IncludeComponentTemplate();
?>