<?
session_start();
CModule::AddAutoloadClasses(
    '', // не указываем имя модуля
    array(
        // ключ - имя класса, значение - путь относительно корня сайта к файлу с классом
        'Validator' => '/bitrix/components/res/form/validator.php',
    )
);
CModule::AddAutoloadClasses(
    '', // не указываем имя модуля
    array(
        // ключ - имя класса, значение - путь относительно корня сайта к файлу с классом
        'ComponentFormElement' => '/bitrix/components/res/form/formElement.php',
    )
);
?>