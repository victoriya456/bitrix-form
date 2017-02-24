<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

\CBitrixComponent::includeComponentClass("res:form");

class ComponentFormElement extends CIBlockElement{

    protected $name;
    protected $code;
    protected $modified_by;
    protected $iblockSectionID = false;
    protected $iblockID;
    protected $active;
    protected $previewText;
    protected $detailText;
    protected $dataActiveForm;

    protected $formRequests;

    protected $fieldsValues = array();
    protected $arLoadProductArray = array();

    public function __construct($IBLOCK_ID, $fields, $form_requests, $name = '',$previewText = '', $detailText = '', $sectionID = false){
        $this->setActive("Y");
        $this->setDataActiveForm(ConvertTimeStamp(time(), "FULL"));
        $this->setModifiedBy($GLOBALS['USER']->GetID());
        $this->setDetailText($detailText);
        $this->setPreviewText($previewText);
        $this->setName($name);
        $params = array("replace_space"=>"-","replace_other"=>"-","change_case"=>"L");
        $this->setCode(CUtil::translit($name, "ru" , $params));
        $this->setIblockID($IBLOCK_ID);
        $this->setIblockSectionID($sectionID);

        $this->setArLoadProductArray();
        $this->setFormRequests($form_requests);
        $this->setFieldsValues($fields);

    }

    public function SaveBaseElement(){
        if($product_id = $this->Add($this->getArLoadProductArray())) {
            return $product_id;
        } else {
            return $this->LAST_ERROR;
        }
    }

    public function AddPropertyValues($product_id){
        foreach ($this->getFieldsValues() as $name_field => $type){
            switch ($type) {
                case "STRING":
                    parent::SetPropertyValueCode($product_id, $name_field, $this->getFormRequestByKey($name_field));
                    break;
                case "HTML":
                    parent::SetPropertyValueCode($product_id, $name_field, array("VALUE"=>array("TEXT"=>$this->getFormRequestByKey($name_field), "TYPE"=>"html")));
                    break;
            }
        }
    }

    public function SaveElement(){
        $product_id = $this->SaveBaseElement();
        if(is_int($product_id)){
            $this->AddPropertyValues($product_id);
        }else{
            return false;
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * @param mixed $modified_by
     */
    public function setModifiedBy($modified_by)
    {
        $this->modified_by = $modified_by;
    }

    /**
     * @return boolean
     */
    public function getIblockSectionID()
    {
        return $this->iblockSectionID;
    }

    /**
     * @param boolean $iblockSectionID
     */
    public function setIblockSectionID($iblockSectionID)
    {
        $this->iblockSectionID = $iblockSectionID;
    }

    /**
     * @return mixed
     */
    public function getIblockID()
    {
        return $this->iblockID;
    }

    /**
     * @param mixed $iblockID
     */
    public function setIblockID($iblockID)
    {
        $this->iblockID = $iblockID;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getPreviewText()
    {
        return $this->previewText;
    }

    /**
     * @param mixed $previewText
     */
    public function setPreviewText($previewText)
    {
        $this->previewText = $previewText;
    }

    /**
     * @return mixed
     */
    public function getDetailText()
    {
        return $this->detailText;
    }

    /**
     * @param mixed $detailText
     */
    public function setDetailText($detailText)
    {
        $this->detailText = $detailText;
    }

    /**
     * @return array
     */
    public function getFieldsValues()
    {
        return $this->fieldsValues;
    }

    /**
     * @param array $fieldsValues
     */
    public function setFieldsValues($fieldsValues)
    {
        $this->fieldsValues = $fieldsValues;
    }

    /**
     * @return mixed
     */
    public function getDataActiveForm()
    {
        return $this->dataActiveForm;
    }

    /**
     * @param mixed $dataActiveForm
     */
    public function setDataActiveForm($dataActiveForm)
    {
        $this->dataActiveForm = $dataActiveForm;
    }

    /**
     * @return mixed
     */
    public function getFormRequests()
    {
        return $this->formRequests;
    }

    public function getFormRequestByKey($key){
        return $this->getFormRequests()[$key];
    }
    /**
     * @param mixed $formRequests
     */
    public function setFormRequests($formRequests)
    {
        $this->formRequests = $formRequests;
    }

    /**
     * @return array
     */
    public function getArLoadProductArray()
    {
        return $this->arLoadProductArray;
    }

    /**
     * @param array $arLoadProductArray
     */
    public function setArLoadProductArray()
    {
        $arLoadProductArray = Array(
            'MODIFIED_BY' => $this->getModifiedBy(),
            'IBLOCK_SECTION_ID' => $this->getIblockSectionID(),
            'IBLOCK_ID' => $this->getIblockID(),
            'NAME' => $this->getName(),
            'DATE_ACTIVE_FROM' => $this->getDataActiveForm(),
            'ACTIVE' => $this->getActive(),
            'PREVIEW_TEXT' => $this->getPreviewText(),
            'DETAIL_TEXT' => $this->getDetailText(),
            'CODE' => $this->getCode(),
        );
        $this->arLoadProductArray = $arLoadProductArray;
    }


}