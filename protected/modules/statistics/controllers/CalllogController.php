<?php

class CalllogController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow',
                'actions'=>array('index'),
                'roles'=>array('manageReports'),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new CallLog('search');
        $data = array(
            'filter' => array(),
            'show' => $model->getDefaultShowAttributes(),
            'fields' => $model->getShowableFieldList(),
            'group' => array(),
            'aggregate' => array(),
            'able' => array(
                'show' => $model->getShowableFieldList(),
                'group' => $model->getGroupableFieldList(),
                'aggregate' => $model->getAggregatableFieldList(),
            ),
        );

		$model->unsetAttributes();  // clear any default values
		if(isset($_REQUEST['CallLog'])){
            $data['filter'] = $_REQUEST['CallLog'];
            $model->attributes = $data['filter'];
        }

        if (isset($_REQUEST['Group'])) {
            $data['group'] = array_keys($_REQUEST['Group']);
            $model->setGroup($data['group']);
        }

        if (isset($_REQUEST['Aggregate'])) {
            $data['aggregate'] = $_REQUEST['Aggregate'];
            $model->setAggregate($data['aggregate']);
        }

        if(isset($_REQUEST['Show'])) {
            $data['show'] = array_intersect($data['fields'], array_keys($_REQUEST['Show']));
        }
        $model->setShow($data['show']);

        if(Yii::app()->request->getParam('export')) {
            $export = new ExportToExcel($model, $model->getShow());
            $export->export();
            Yii::app()->end();
        }

		$this->render('admin',array(
			'model'=>$model,
            'data' => $data,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CallLog::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='call-log-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
