<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php //var_dump($arResult["error_message"]); ?>

<?php if(!empty($arParams["FORM_TITLE"])): ?>
    <h2><?=$arParams["FORM_TITLE"]?></h2>
<?php endif; ?>

<form name="<?=$arParams["FORM_ID"]?>" action="<?=POST_FORM_ACTION_URI?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="WEB_FORM_ID" value="<?=$arParams["FORM_ID"]?>">
    <?=bitrix_sessid_post()?>
    
    <input type="text" name="name" placeholder="" /><span style="color: darkred"><?=$arResult["error_message"]["name"][0]?></span><br>
    <input type="text" name="email" placeholder="" /><span style="color: darkred"><?=$arResult["error_message"]["email"][0]?></span><br>
    <input type="text" name="phone" placeholder="" /><span style="color: darkred"><?=$arResult["error_message"]["phone"][0]?></span><br>
    <textarea cols="6" name="message" ></textarea><span style="color: darkred"><?=$arResult["error_message"]["message"][0]?></span><br>

    <?php if($arParams["USE_CAPTCHA"] == "Y"): ?>
        <input type="hidden" name="captcha_sid" value="<?=$arResult["captcha"];?>" />
        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["captcha"];?>" alt="CAPTCHA" />
        <input type="text" name="captcha_word" size="30" maxlength="50" value=""><br>
        <span style="color: darkred;padding-left: 10px"><?=$arResult["error_message"]["captcha"]?></span>
    <? endif; ?>
    <input type="submit" value="Send" name="submit">
    <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
</form>

<span style="color: limegreen;"><?=$arResult["success"]?></span>

