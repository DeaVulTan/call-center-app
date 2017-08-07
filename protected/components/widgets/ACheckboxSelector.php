<?php

class ACheckboxSelector extends CWidget
{
    public $id = 'id';
    public $name = '';
    public $module = 'Form';
    public $data = [];
    public $value = [];
    public $title = '';

    public function run()
    {
        Yii::app()->getClientScript()->registerScriptFile('/js/angular/widgets/checkboxSelector.js');
        Yii::app()->getClientScript()->registerScriptFile('/js/angular.min.js');

        foreach ($this->data as $key => $val) {
            if (!empty($this->value) && in_array($val['id'], $this->value)) {
                $this->data[$key]['selected'] = true;
            } else {
                $this->data[$key]['selected'] = false;
            }
        }

        $this->render('aCheckboxSelector', array(
            'data' => $this->data,
            'title' => $this->title,
            'name' => $this->module . '[' . $this->name . ']',
            'fieldName' => $this->name,
            'value' => $this->value,
        ));
    }

}