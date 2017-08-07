<?php

/**
 *
 */
class OperatorpanelController extends Controller
{
	public $opQueue = array();

	/**
	 * @return array
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
		return [
            'postOnly + savenote',
			[
                'allow',
                'actions' => ['index', 'monitor', 'savenote', 'redirectcall', 'callpickup', 'calltransfer', 'savepanelcfg', 'loadpanelcfg','sendsms','getdata'],
                'roles' => ['viewOperatorPanel']
			],
            ['allow', 'actions' => ['calloverhear', 'callmaster'], 'roles' => ['admin', 'supervisor']],
			['allow', 'actions' => ['*'], 'roles' => ['admin']],
			['deny', 'users' => ['*']],
		];
	}

	/**
	 *
	 */
	public function actionIndex()
	{
		//Инициализируем нужные библиотеки
		Yii::app()->getClientScript()->registerCoreScript('jquery');
		Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
		Yii::app()->getClientScript()->registerScriptFile('/js/operatorPanel.js');
		Yii::app()->getClientScript()->registerScriptFile('/js/colResizable-1.3.min.js');
        Yii::app()->getClientScript()->registerScriptFile('/js/angular.min.js');
        Yii::app()->getClientScript()->registerScriptFile('/js/angular/timer.js');
        Yii::app()->getClientScript()->registerScriptFile('/js/angular/angular-websocket.js');
		//Стили к библиотекам
		Yii::app()->getClientScript()->registerCssFile(Yii::app()
			->getClientScript()
			->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
        Yii::app()->getClientScript()->registerCssFile('/css/operatorpanel.css');

        $switching = Switching::model()
            ->scopeUser()
            ->with('group')
            ->together()
            ->findAll([
                'condition' => 'deleted = 0 or common = 1',
                'order'     => 't.common DESC, group.name, t.name'
            ]);

        $tmp = [];
		foreach($switching as $switch) {
			if(!isset($tmp[$switch->group->name]) && $switch->common != 1) {
				$tmp[$switch->group->name] = array();
			}
			$tmp[($switch->common == 1)?'Общая':$switch->group->name][] = array(
                'id'=>$switch->id,
                'text'=>$switch->name,
			);
		}

        $switches = [];
		foreach($tmp as $gname=>$items) {
            $switches[] = [
				'text'=>$gname,
				'expanded'=>false,
				'children'=>$items
			];
		}

		//Сами скрипты для работы
		$this->render('index', [
            'switches' => json_encode($switches),
            'data' => json_encode(Yii::app()->op->getMonitorData(['user_login' => Yii::app()->user->getId()], true)),
            'statistics' => json_encode(Yii::app()->op->getStatistics()),
            'wsCometSid' => Yii::app()->op->getUserCometSid(),
            'wsChannel' => 'user_' . Yii::app()->user->getId() . '/op_data',
            'wsCometUrl' => Yii::app()->comet->host . ':' . Yii::app()->comet->port,
        ]);
	}

    public function actionGetData()
    {
        echo json_encode(Yii::app()->op->getMonitorData());
    }

	public function actionSavenote()
    {
        $log_file = '/usr/local/nginx/html/callcenter/protected/data/logs/savenote.log';
        file_put_contents(
            $log_file,
            file_get_contents($log_file) . "\n" .
            date('Y-m-d H:i:s') . ', ' .  Yii::app()->user->getName() . ': ' .  json_encode($_POST)
        );
		$result = true;
		if(Yii::app()->request->isAjaxRequest) {
            $linkedid =  str_replace('-', '.', Yii::app()->request->getPost('linkedid', false));
            $group_id = Yii::app()->request->getPost('group_id', '');
            $cid = Yii::app()->request->getPost('cid', '');
            if(isset($_POST['linkedid']) && $linkedid !== false) {
                $transaction = NoteValues::model()->dbConnection->beginTransaction();
                try {
                    $data = [];
                    foreach ($_POST as $name=>$value) {
                        if (is_array($value)) {
                            $value = implode(', ', $value);
                        }
                        if(strstr($name, 'field') && ($fieldId = intval(str_replace('field', '', $name)))) {
                            $data[] = $value;
                            if (empty($value)) {
                                if (NoteField::model()->findByPk($fieldId)->is_important == 1) {
                                    $result = false;
                                    break;
                                }
                                continue;
                            }

                            $note = new NoteValues;
                            $note->field_type = $fieldId;
                            $note->value = $value;
                            $note->linkedid = $linkedid;
                            if (!$note->save()) {
                                $result = false;
                                break;
                            }
                        }
                    }

                } catch (Exception $e) {
                    $transaction->rollback();
                    throw $e;
                }

                if($result) {
                    $transaction->commit();
                    if (!empty($data) && !empty($group_id)) {
                        if (Yii::app()->notesSaver->loadSettingFromGroup($group_id)) {
                            Yii::app()->notesSaver->saveNote($data, $linkedid, $cid);
                        }
                    }
                } else {
                    $transaction->rollback();
                }
			}
		}
		print $result?'ok':'Ошибка сохранения';
	}


	public function actionRedirectcall() {
		if(Yii::app()->request->isAjaxRequest) {
			$ami_params = Yii::app()->params['ami'];
			$ami = new Ami($ami_params['host'], $ami_params['port'], $ami_params['amiuser'], $ami_params['amipassword']);
			$ami->redirectCall($_POST['id']);
		}
	}


    /**
     * забрать на себя звонок
     */
    public function actionCallpickup() {
        if(Yii::app()->request->isAjaxRequest) {
            $ami_params = Yii::app()->params['ami'];
            $ami = new Ami($ami_params['host'], $ami_params['port'], $ami_params['amiuser'], $ami_params['amipassword']);
            $ami->callPickup($_POST['id']);
        }
    }


    /**
     * перевод звонока
     */
    public function actionCalltransfer() {
        if(Yii::app()->request->isAjaxRequest) {
            $ami_params = Yii::app()->params['ami'];
            $ami = new Ami($ami_params['host'], $ami_params['port'], $ami_params['amiuser'], $ami_params['amipassword']);
            $ami->callTransfer($_POST['callTransferCallId'], $_POST['operatorId']);
        }
    }


    /**
     * подслушать звонок
     */
    public function actionCalloverhear() {
        if(Yii::app()->request->isAjaxRequest) {
            $ami_params = Yii::app()->params['ami'];
            $ami = new Ami($ami_params['host'], $ami_params['port'], $ami_params['amiuser'], $ami_params['amipassword']);
            $ami->callOverhear($_POST['id']);
        }
    }


    /**
     * включение режима мастер-ученик
     */
    public function actionCallmaster() {
        if(Yii::app()->request->isAjaxRequest) {
            $ami_params = Yii::app()->params['ami'];
            $ami = new Ami($ami_params['host'], $ami_params['port'], $ami_params['amiuser'], $ami_params['amipassword']);
            $ami->callMaster($_POST['id']);
        }
    }


    public function actionSavepanelcfg() {
        $user = User::model()->findByPk(Yii::app()->user->getId());
        $user->panel_cfg = json_encode($_POST);
        $user->save();
    }

    public function actionSendsms() {
        if(Yii::app()->request->isAjaxRequest) {
            $linkedId = str_replace('-', '.', Yii::app()->request->getPost('smsLinkedId'));
            Yii::app()->getModule('statistics');
            /** @var GroupCallRealtime $gcr */
            $gcr = GroupCallRealtime::model()->findByAttributes(['linkedid' => $linkedId]);

            if (is_null($gcr)) {
                $gcr = CallLog::model()->findByAttributes(['linkedid' => $linkedId]);
            }

            if (is_null($gcr)) {
                echo "Ошибка отправки СМС. Не найдена запись о звонке";
                exit;
            }

            $phone = substr($gcr->cid, -10, 10);
            if (strlen($phone) < 10) {
                echo "Ошибка отправки СМС. Номер не определен";
                exit;
            }

            $sms = new Sms;
            $sms->user_id = Yii::app()->user->getId();
            $sms->sender = $gcr->group->sms_sender;
            $sms->phone = $phone;
            $sms->created_at = new CDbExpression('NOW()');
            $sms->body = Yii::app()->request->getPost('smsText');
            $sms->linkedid = $gcr->linkedid;
            $sms->group_id = $gcr->group_id;
            if ($sms->save()) {
                echo "Смс успешно отправлено";
                exit;
            }
            echo "Ошибка отправки смс:\n";
            if (!is_null($sms->getError('sender'))) {
                echo "Не заполнено поле Отправитель\n";
            }
            echo "\nОбратитесь к администратору системы";
            exit;
        }
    }

    public function actionLoadpanelcfg() {
        print User::model()->getPanelCfg();
    }
}
