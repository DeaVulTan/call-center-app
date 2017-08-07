<?php

class TemplateController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $defaultAction = 'admin';
    protected $is_check = false;
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
				'actions'=>array('view','report','check','help','getfile'),
				'roles'=>array('manageReports'),
			),
            array('allow',
                'actions'=>array('view','create','update','admin','delete','report','check','help','getfile'),
                'roles'=>array('canUseReportsEditor'),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ReportTemplate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ReportTemplate']))
		{
			$model->attributes=$_POST['ReportTemplate'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ReportTemplate']))
		{
			$model->attributes=$_POST['ReportTemplate'];
            if ($model->is_published == '1') {
                $_POST['sql'] = $model->sql;
                $_POST['translate'] = $model->translate;
                $this->is_check = true;
                if (!$this->actionCheck()) {
                    $model->is_published = '0';
                    Yii::app()->user->setFlash('warning',"Отчет сохранен, но содержит ошибки и не может быть опубликован");
                }
            }
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ReportTemplate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ReportTemplate']))
			$model->attributes=$_GET['ReportTemplate'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionReport()
	{
		if(isset($_GET['id'])) {
			$reportParams = [];
			if(isset($_REQUEST['Report'])) {
				$reportParams = $_REQUEST['Report'];
			}
			$model = $this->loadModel($_GET['id']);
			$query = $model->sql;
			$translate = [];
			foreach (explode("\n", $model->translate) as $val) {
				$tmp = explode('|', $val);
				if (count($tmp) != 2) continue;
				$translate[$tmp[0]] = trim($tmp[1]);
			}

			$params = $this->_getReportParameter($query, $reportParams, $translate);
			// replace sql parameters
			$paramsForProvider = [];
			foreach ($params as $key => $val) {
				$query = str_replace($val['sqlParamOrigin'], $val['sqlParamNew'], $query);
				switch ($val['type']) {
					case 'text':
						if (is_null($val['value'])) break;
						$paramsForProvider[$val['name']] = $val['value'];
						break;
                    case 'checkboxes':
                        break;
					case 'date':
						$to = (empty($val['value'][1]) ? '2037-01-01' : trim($val['value'][1]));
						if (strlen($to) == 10) {
							$to = $to . ' 23:59:59';
						}

                        // Если дата не задана, то считаем от вчерашней, чтобы не выполнять лишний раз тяжелые запросы
                        if (empty($params[$key]['value'][0])) {
                            $yesterday = date('Y-m-d', time() - 24 * 3600);
                            $params[$key]['value'][0] = $yesterday;
                            $val['value'][0] = $yesterday;
                        }

						$paramsForProvider[$val['name'] . '_from'] = $val['value'][0];

						$paramsForProvider[$val['name'] . '_to']   = $to;
						break;
					default:
				}
			}

            // clean useless param`s attributes
            unset($params['sqlParamNew']);
            unset($params['sqlParamOrigin']);

			$cmd = Yii::app()->db_readonly->createCommand($query);
			foreach ($params as $val) {
				switch ($val['type']) {
                    case 'text':
                        if (!is_null($val['value']))
                            $cmd->bindValue($val['name'], $val['value']);
                        break;
                    case 'checkboxes':
                        break;
					case 'date':
						$to = (empty($val['value'][1]) ? '2037-01-01' : trim($val['value'][1]));
						if (strlen($to) == 10) {
							$to = $to . ' 23:59:59';
						}

						$cmd->bindValue($val['name'] . '_from',$val['value'][0]);
						$cmd->bindValue($val['name'] . '_to',   $to);
						break;
					default:
				}
			}
			$queryAll = $cmd->queryAll();
            // если включен режим проверки, то вернуть true, т.к. если бы была ошибка то выпал ексепшен
            if ($this->is_check) {
                return true;
            }

            if (isset($_REQUEST['export']) && $_REQUEST['export'] == 1) {
                // getting field for total
                preg_match_all('/as ([\.a-zA-Z0-9_-]+__[a-z]*)/i', $query, $matches);
                $matches = array_unique($matches[1]);
                $fields = [];
                foreach ($matches as $field) {
                    $paramArr = explode('__', $field);
                    $fields[$field] = $paramArr[1];
                }
                $this->_exportReport($queryAll, $fields, $translate);
                Yii::app()->end();
            }
			$count = count($queryAll);
			$columnList = empty($count) ? ['id'] : array_keys($queryAll[0]);
			$columns = [];
			foreach ($columnList as $col) {
                $column = [
                    'header' => array_key_exists($col, $translate) ? $translate[$col] : $col,
                    'name' => $col,
                ];

                switch ($col) {
                    case 'filename':
                        $column['type'] = 'raw';
                        $column['value'] = '(array_key_exists("filename", $data) && !empty($data["filename"]))? \'<a href="#" class="btn btn-file" data-filename="\'.urlencode($data["filename"]).\'">Прослушать</a>\':""';
                        break;
                    default:
                }
				$columns[] = $column;
			}

			$dataProvider = new CSqlDataProvider($query, array(
				'db'             => Yii::app()->db_readonly,
				'totalItemCount' => $count,
				'pagination'     => array(
					'pageSize'=>30,
				),
				'sort'           => array('defaultOrder'=>'1 DESC',
                'attributes'     => $columnList,
				),
				'params'         => $paramsForProvider,
				'keyField'       => $columnList[0],
			));

			$this->render('report',array(
				'columns' => $columns,
				'params' => $params,
				'model' => $model,
				'dataProvider'=>$dataProvider,
			));
		} else {
			$this->render('report',array(
				'model'=>ReportTemplate::model(),
			));
		}
	}

    public function actionCheck()
    {
        try {
            $reportParams = [];
            $query = $_POST['sql'];
            $translate = [];
            foreach (explode("\n", $_POST['translate']) as $val) {
                $tmp = explode('|', $val);
                if (count($tmp) != 2) continue;
                $translate[$tmp[0]] = trim($tmp[1]);
            }

            $params = $this->_getReportParameter($query, $reportParams, $translate);
            // replace sql parameters
            $paramsForProvider = [];
            foreach ($params as $key => $val) {
                $query = str_replace($val['sqlParamOrigin'], $val['sqlParamNew'], $query);
                switch ($val['type']) {
                    case 'text':
                        if (is_null($val['value'])) break;
                        $paramsForProvider[$val['name']] = $val['value'];
                        break;
                    case 'date':
                        // Если дата не задана, то считаем от вчерашней, чтобы не выполнять лишний раз тяжелые запросы
                        if (empty($params[$key]['value'][0])) {
                            $yesterday = date('Y-m-d', time() - 24 * 3600);
                            $params[$key]['value'][0] = $yesterday;
                            $val['value'][0] = $yesterday;
                        }

                        $paramsForProvider[$val['name'] . '_from'] = $val['value'][0];
                        $paramsForProvider[$val['name'] . '_to']   = (empty($val['value'][1]) ? '2037-01-01' : $val['value'][1]);
                        break;
                    default:
                }
            }
            // clean useless param`s attributes
            unset($params['sqlParamNew']);
            unset($params['sqlParamOrigin']);

            $cmd = Yii::app()->db_readonly->createCommand($query);
            $parameters = array(); // Параметры для вывода результатов проверки
            foreach ($params as $val) {
                switch ($val['type']) {
                    case 'text':
                        if (!is_null($val['value']))
                            $cmd->bindValue($val['name'], $val['value']);
                        break;
                    case 'date':
                        $cmd->bindValue($val['name'] . '_from', $val['value'][0]);
                        $cmd->bindValue($val['name'] . '_to',   (empty($val['value'][1]) ? '2037-01-01' : $val['value'][1]));
                        break;
                    default:
                }
                $parameters[] = $val['header'] . ' (' . $val['type'] . ')';
            }

            $queryAll = $cmd->queryAll();
            $count = count($queryAll);
            $columnList = empty($count) ? ['id'] : array_keys($queryAll[0]);
            $columns = [];
            foreach ($columnList as $col) {
                $columns[] = array_key_exists($col, $translate) ? $translate[$col] : $col;
            }
            if ($this->is_check) {
                return true;
            }
            echo json_encode(array(
                'text' => '<b>Количество записей:</b> ' . $count . '<br>'
                    . '<b>Столбцы:</b><br><ul><li>' . implode('</li><li>', $columns) . '</li></ul>'
                    . '<b>Параметры:</b><br><ul><li>' . implode('</li><li>', $parameters) . '</li></ul>'
            ));
        } catch (Exception $e) {
            if ($this->is_check) {
                return false;
            }
            echo json_encode(array(
                'text' => $e->getMessage(),
            ));
        }
    }

    public function actionGetfile(){

        $filePath = realpath(rawurldecode($_GET['file']));

        if ($filePath !== false && !preg_match('/\/var\/spool\/asterisk\/.*\.(mp3|wav)/', $filePath)) {
            throw new CHttpException(404, 'Not found');
        }

        Yii::app()->getRequest()->sendFile( basename($filePath) , file_get_contents( $filePath ) );
    }

    public function actionHelp()
    {
        $this->render('help');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param $id
     * @throws CHttpException
     * @internal param \ID $integer of the model to be loaded
     * @return \CActiveRecord
     */
	public function loadModel($id)
	{
		$model=ReportTemplate::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='report-template-form')
		{
			echo CActiveForm::validate($model);
            Yii::app()->end();
		}
	}

    protected function _exportReport($data, $totalFields = [], $translate = [])
    {
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=export_" . date("Y-m-d") . ".csv");
        header("Content-Transfer-Encoding: binary");

        if (empty($data)) {
            echo "По указанным параметрам данные отсутствуют";
            die;
        }
        $row = [];
        $df = fopen("php://output", 'w');
        foreach (array_keys($data[0]) as $val) {
            $row[] = array_key_exists($val, $translate) ? $translate[$val] : $val;
        }
        $this->_putCsvLine($df, $row);

        foreach($data as $val) {
            $this->_putCsvLine($df, $val);
        }

        if (!empty($totalFields)) {
            //TODO: возможно стоит транспонировать матрицу с данными и вырезать ненужная столбцы
            $total = [];
            $totalType = [];
            foreach ($data as $row) {
                foreach ($row as $key => $val) {
                    if (is_null($val)) {
                        continue;
                    }

                    if (array_key_exists($key, $totalFields)) {
                        if (strpos($val, ':')) {
                            if (preg_match('/^-?\d+:\d+:\d+$/', $val)) {
                                $totalType[$key] = 'time';
                                $val = $this->getSecondsFromTime($val);
                            } elseif (preg_match('/^\d+-\d+-\d+ \d+:\d+:\d+$/', $val)) {
                                $totalType[$key] = 'date';
                                $val = strtotime($val);
                            } else {
                                throw new Exception('Unknown time format: ' . $val);
                            }

                        } else {
                            $totalType[$key] = 'int';
                        }

                        switch ($totalFields[$key]) {
                            case 'avg':
                                if (!array_key_exists($key, $total)) {
                                    $total[$key] = [];
                                }
                                $total[$key][] = $val;
                                break;
                            case 'max':
                                if (!array_key_exists($key, $total)) {
                                    $total[$key] = $val;
                                }
                                if ($total[$key] < $val) {
                                    $total[$key] = $val;
                                }
                                break;
                            case 'min':
                                if (!array_key_exists($key, $total)) {
                                    $total[$key] = $val;
                                }
                                if ($total[$key] > $val) {
                                    $total[$key] = $val;
                                }
                                break;
                            case 'sum':
                                if (!array_key_exists($key, $total)) {
                                    $total[$key] = 0;
                                }
                                $total[$key] += $val;
                                break;
                            default:
                        }
                    }
                }
            }
            foreach ($total as $key => $row) {
                if (is_array($row)) {
                    $total[$key] = round((array_sum($row) / count($row)), 2);
                } else {
                    $total[$key] = round($row, 2);
                }
                if ($totalType[$key] == 'time') {
                    $total[$key] = $this->getTimeFromSeconds($total[$key]);
                }
                if ($totalType[$key] == 'date') {
                    $total[$key] = date('Y-m-d H:i:s', $total[$key]);
                }
            }
            $row = [];
            foreach ($data[0] as $key => $val) {
                if (array_key_exists($key, $total)) {
                    $row[] = $total[$key];
                } else {
                    if (empty($row)) {
                        $row[] = 'Итого';
                    } else {
                        $row[] = '';
                    }
                }
            }
            $this->_putCsvLine($df, $row);
        }
        fclose($df);
        die();
    }

    protected function _putCsvLine($file, $data) {
        array_walk(
            $data,
            function (&$entry) {
                $entry = iconv('UTF-8', 'Windows-1251', $entry);
            }
        );

        fputcsv($file, $data, ';', '"');
        return true;
    }

	private function _getReportParameter($query, $data, $translate)
	{
		// get list of parameters
		preg_match_all('/[\.a-zA-Z_-]+\$[a-z]*/', $query, $matches);
        preg_match_all('/(?P<name>[\.a-zA-Z_-]+)\$(?P<type>[a-z]*)(\{\{(?P<query>.*?)\}\})*/', $query, $matches, PREG_SET_ORDER);
		$params = [];
		foreach ($matches as $param) {
			$type = $param['type'];
			$name = str_replace('.', '_', $param['name']);

			$newParam = [
				'sqlParamOrigin' => $param[0],
				'name' => $name,
				'header' => array_key_exists($name, $translate) ? $translate[$name] : $name,
				'originParam' => $param['name'],
			];
			switch ($type) {
				case 'date':
					$newParam += [
                        // (created_at between :created_at_from and :created_at_to)
						'sqlParamNew' => "(" . $param['name'] . " between :" . $name . "_from and :" . $name . "_to)",
						'type' => 'date',
						'value' => [
							array_key_exists($name . '_from', $data) ? $data[$name . '_from'] : '',
							array_key_exists($name . '_to', $data) ? $data[$name . '_to'] : '',
						]
					];
					break;
                case 'checkboxes':
                    $query = '';
                    if (array_key_exists($name, $data)) {
                        $aQuery = [];
                        if (!is_array($data[$name])) {
                            $data[$name] = [$data[$name]];
                        }
                        $tmpData = array_keys($data[$name]);
                        foreach ($tmpData as $key => $val) {
                            $aQuery[] = '\'' . str_replace('\'', "\\'", $val) . '\'';
                        }
                        $query = implode(',', $aQuery);
                    }
                    $newParam += [
                        'sqlParamNew' => (array_key_exists($name, $data) && !empty($data[$name])) ? $param['name'] . ' in (' . $query . ')': '1=1',
                        'type' => 'checkboxes',
                        'value' => array_key_exists($name, $data) && !empty($data[$name]) ? array_keys($data[$name]) : null,
                        'data' => Yii::app()->db_readonly->createCommand($param['query'])->queryAll(),
                    ];
                    break;
				default:
					$newParam += [
						'sqlParamNew' => (array_key_exists($name, $data) && !empty($data[$name])) ? $param['name'] . " like :" . $name : '1=1',
						'type' => 'text',
						'value' => (array_key_exists($name, $data) && !empty($data[$name])) ? '%'.$data[$name].'%' : null,
					];
			}
			$params[] = $newParam;
		}
		return $params;
	}

    /**
     * Получение кол-во секунд из времени формата h:m:s
     *
     * @param $time string
     * @return integer
     * @throws Exception
     */
    protected function getSecondsFromTime($time)
    {
        $parts = explode(':', $time);
        if (count($parts) != 3) {
            throw new Exception ('Incorrect time format');
        }
        $result = $parts[0] * 60 * 60 + $parts[1] * 60 + $parts[2];
        return $result;
    }

    /**
     * Получение стоки времени вида h:m:s где кол-во часов не ограничено
     *
     * @param $seconds integer
     * @return string
     */
    protected function getTimeFromSeconds($seconds)
    {
        return sprintf("%02d:%02d:%02d", floor($seconds/3600), abs(($seconds/60)%60), abs($seconds%60));
    }
}
