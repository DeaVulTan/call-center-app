<?php

class SettingController extends Controller
{
	public $layout='//layouts/column2';
    public $defaultAction = 'admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('update', 'admin'),
                'roles'=>array('canEditSetting'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if(!empty($_POST))
		{
            $data = $_POST;
            foreach ($data as $key => $val) {
                /** @var Setting $setting */
                $setting = Setting::model()->findByAttributes(['name' => $key]);
                if (is_null($setting)) {
                    continue;
                }
                $setting->value = $val;
                $setting->save();
            }
		}

        $models = Setting::model()->findAllByAttributes(['category_id' => $id]);

		$resultModels = [];
		foreach ($models as $key => $val) {
			$resultModels[$val->name] = $val;
		}

        $this->render('update',array(
            'id'     => $id,
			'models' => $resultModels,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->render('admin');
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='setting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
