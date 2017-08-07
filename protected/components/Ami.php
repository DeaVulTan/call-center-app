<?php

/**
 * Ami класс для работы с ами-командами астериска
 *
 * @author Tursunov Artem <artem.tur@gmail.com>
 */
class Ami {

    public $host = false;
    public $port = false;
    public $amiuser = false;
    public $amipassword = false;

    /** @var bool | resource  */
    public $connection = false;

    public function __construct($host, $port, $amiuser, $amipassword) {
        $this->host = $host;
        $this->port = $port;
        $this->amiuser = $amiuser;
        $this->amipassword = $amipassword;
        if (!($this->host && $this->port && $this->amiuser && $this->amipassword))
            throw new Exception('Incorrect ami connection params');
    }

    private function _openConnection() {
        $this->connection = fsockopen($this->host, $this->port, $errnum, $errdesc) or die("Connection to host failed");
    }

    private function _putCommand($cmd) {
        fputs($this->connection, "Action: login\r\n");
        fputs($this->connection, "Events: off\r\n");
        fputs($this->connection, "Username: $this->amiuser\r\n");
        fputs($this->connection, "Secret: $this->amipassword\r\n\r\n");
        fputs($this->connection, "Action: COMMAND\r\n");
        fputs($this->connection, "command: $cmd\r\n\r\n");
        fputs($this->connection, "Action: Logoff\r\n\r\n");
    }

    private function _redirect($channel_name, $number, $addition) {
        fputs($this->connection, "Action: login\r\n");
        fputs($this->connection, "Events: off\r\n");
        fputs($this->connection, "Username: $this->amiuser\r\n");
        fputs($this->connection, "Secret: $this->amipassword\r\n\r\n");
        fputs($this->connection, "Action: Redirect\r\n");
        fputs($this->connection, "Channel: $channel_name\r\n");
        fputs($this->connection, "Exten: $number\r\n");
        fputs($this->connection, "Context: transfer-by-operator\r\n");
        fputs($this->connection, "Priority: 1\r\n\r\n");
        fputs($this->connection, "Action: Setvar\r\n");
        fputs($this->connection, "Channel: $channel_name\r\n");
        fputs($this->connection, "Variable: TRANSFERED_BY_OPERATOR\r\n");
        fputs($this->connection, "Value: yes\r\n\r\n");
        fputs($this->connection, "Action: Setvar\r\n");
        fputs($this->connection, "Channel: $channel_name\r\n");
        fputs($this->connection, "Variable: ADDITION\r\n");
        fputs($this->connection, "Value: $addition\r\n\r\n");
        fputs($this->connection, "Action: Logoff\r\n\r\n");
    }


    private function _outgoing($operator_number, $external_number) {
        fputs($this->connection, "Action: login\r\n");
        fputs($this->connection, "Events: off\r\n");
        fputs($this->connection, "Username: $this->amiuser\r\n");
        fputs($this->connection, "Secret: $this->amipassword\r\n\r\n");
        fputs($this->connection, "Action: Originate\r\n");
        fputs($this->connection, "Channel: SIP/$operator_number\r\n");
        fputs($this->connection, "Context: mn\r\n");
        fputs($this->connection, "Exten: $external_number\r\n");
        fputs($this->connection, "Priority: 1\r\n");
        fputs($this->connection, "Callerid: $operator_number\r\n");
        fputs($this->connection, "Timeout: 30000\r\n");
        fputs($this->connection, "Action: Logoff\r\n\r\n");

    }

    /**
     * @param $channel_name - имя канала внешнего абонента(group_call_realtime.cid_chan)
     * @param $number - внутренний номер оператора, который перехватывает вызов
     * @param $group_moh - класс музыки на удержании в группе, из которой был перехвачен звонок(queue_table.musiconhold)
     * @param $qname - имя очереди в группе, из которой был перехвачен звонок(group.qname)
     */
    private function _getCall($channel_name, $number, $group_moh, $qname) {
        fputs($this->connection, "Action: login\r\n");
        fputs($this->connection, "Events: off\r\n");
        fputs($this->connection, "Username: $this->amiuser\r\n");
        fputs($this->connection, "Secret: $this->amipassword\r\n\r\n");
        fputs($this->connection, "Action: Redirect\r\n");
        fputs($this->connection, "Channel: $channel_name\r\n");
        fputs($this->connection, "Exten: ".$number."\r\n");
        fputs($this->connection, "Context: pickup-by-operator\r\n");
        fputs($this->connection, "Priority: 1\r\n\r\n");
        fputs($this->connection, "Action: Setvar\r\n");
        fputs($this->connection, "Channel: $channel_name\r\n");
        fputs($this->connection, "Variable: GROUP_MOH\r\n");
        fputs($this->connection, "Value: $group_moh\r\n\r\n");
        fputs($this->connection, "Action: Setvar\r\n");
        fputs($this->connection, "Channel: $channel_name\r\n");
        fputs($this->connection, "Variable: PICKUP_FROM_QUEUE\r\n");
        fputs($this->connection, "Value: $qname\r\n\r\n");
        fputs($this->connection, "Action: Logoff\r\n\r\n");
    }


    private function _transfer($channel_name, $number) {
        fputs($this->connection, "Action: login\r\n");
        fputs($this->connection, "Events: off\r\n");
        fputs($this->connection, "Username: $this->amiuser\r\n");
        fputs($this->connection, "Secret: $this->amipassword\r\n\r\n");
        fputs($this->connection, "Action: Redirect\r\n");
        fputs($this->connection, "Channel: $channel_name\r\n");
        fputs($this->connection, "Exten: $number\r\n");
        fputs($this->connection, "Context: transfer-by-operator\r\n");
        fputs($this->connection, "Priority: 1\r\n\r\n");
        fputs($this->connection, "Action: Setvar\r\n");
        fputs($this->connection, "Channel: $channel_name\r\n");
        fputs($this->connection, "Variable: TRANSFERED_BY_OPERATOR\r\n");
        fputs($this->connection, "Value: yes\r\n\r\n");
        fputs($this->connection, "Action: Setvar\r\n");
        fputs($this->connection, "Channel: $channel_name\r\n");
        fputs($this->connection, "Action: Logoff\r\n\r\n");
    }


    /**
     * Запрос к астериске для включения режима подслушивания
     *
     * @param $operator_number
     * @param $ch_name
     */
    private function _overhear($operator_number, $ch_name)
    {
        fputs($this->connection, "Action: Login\r\n");
        fputs($this->connection, "UserName: $this->amiuser\r\n");
        fputs($this->connection, "Secret: $this->amipassword\r\n\r\n");
        fputs($this->connection, "Action: Originate\r\n");
        fputs($this->connection, "Channel: SIP/$operator_number\r\n");
        fputs($this->connection, "Context: spy\r\n");
        fputs($this->connection, "Exten: spy\r\n");
        fputs($this->connection, "Priority: 1\r\n");
        fputs($this->connection, "Callerid: $operator_number\r\n");
        fputs($this->connection, "Timeout: 30000\r\n");
        fputs($this->connection, "Variable: ch_name=$ch_name\r\n\r\n");
        fputs($this->connection, "Action: Logoff\r\n\r\n");
    }


    /**
     * Запрос к астериске для включения режима Мастер-Ученик
     * Отличается от подслушивания только параметром Context: spy-master\r\n
     *
     * @param $operator_number
     * @param $ch_name
     */
    private function _master($operator_number, $ch_name)
    {
        fputs($this->connection, "Action: Login\r\n");
        fputs($this->connection, "UserName: $this->amiuser\r\n");
        fputs($this->connection, "Secret: $this->amipassword\r\n\r\n");
        fputs($this->connection, "Action: Originate\r\n");
        fputs($this->connection, "Channel: SIP/$operator_number\r\n");
        fputs($this->connection, "Context: spy-master\r\n");
        fputs($this->connection, "Exten: spy\r\n");
        fputs($this->connection, "Priority: 1\r\n");
        fputs($this->connection, "Callerid: $operator_number\r\n");
        fputs($this->connection, "Timeout: 30000\r\n");
        fputs($this->connection, "Variable: ch_name=$ch_name\r\n\r\n");
        fputs($this->connection, "Action: Logoff\r\n\r\n");
    }


    private function _readAnswer() {
        $i = 0;
        $out = '';
        while (!feof($this->connection)) {
            $out.= fread($this->connection, 128);
            $i++;
        }
        return $out;
    }


    private function _closeConnection() {
        fclose($this->connection);
    }

    public function sipReload() {
        try {
            $this->_openConnection();
            $this->_putCommand('sip reload');
            $answer = $this->_readAnswer();
            $this->_closeConnection();
        } catch (Exception $e) {
            throw new Exception('Sip reload failed');
        }
    }


    public function queueShow() {
        try {
            $this->_openConnection();
            $this->_putCommand('queue show');
            $answer = $this->_readAnswer();
            $this->_closeConnection();
        } catch (Exception $e) {
            throw new Exception('Sip reload failed');
        }
    }


    public function redirectCall($redirect_id) {
        try {
            $switching = Switching::model()->findByPk($redirect_id);
            if($switching) {
                $criteria = new CDbCriteria();
                $criteria->addCondition('status = 1 and user_id = '.Yii::app()->user->id);
                $queue = GroupCallRealtime::model()->find($criteria);
                if ($queue) {
                    $this->_openConnection();
                    $this->_redirect(
                        $queue->cid_chan,
                        $switching->prefix . $switching->number,
                        $switching->addition);
                    $answer = $this->_readAnswer();
                    $this->_closeConnection();
                    return;
                }
            }

            $queue = GroupCallRealtime::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
            if (is_null($queue)) {
                $this->_openConnection();
                $this->_outgoing(
                    SipDevices::model()->findByAttributes(['chained_user_id' => Yii::app()->user->getId()])->name,
                    $switching->prefix . $switching->number);
                $answer = $this->_readAnswer();
                $this->_closeConnection();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function callPickup ($call_id) {
        try {
            $call = GroupCallRealtime::model()->with('group')->findByPk($call_id);
            if (is_null($call)) {
                throw new Exception('Call is not found');
            }

            $sipDevice = SipDevices::model()->findByAttributes(['chained_user_id' => Yii::app()->user->getId()]);
            if (is_null($sipDevice)) {
                throw new Exception('Sip devices is not found');
            }

            $queue = QueueTable::model()->findByAttributes(['name' => $call->group->qname]);
            if (is_null($queue)) {
                throw new Exception('Queue is not found');
            }

            $this->_openConnection();
            $this->_getCall(
                $call->cid_chan,
                $sipDevice->name,
                $queue->musiconhold,
                $call->group->qname
            );
            $answer = $this->_readAnswer();
            $this->_closeConnection();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    /**
     * Перевод звонка на другого оператора
     *
     * @param $call_id
     * @param $operator_id
     * @throws Exception
     */
    public function callTransfer($call_id, $operator_id)
    {
        try {
            $call = GroupCallRealtime::model()->findByPk($call_id);
            if (is_null($call)) {
                throw new Exception('Call is not found');
            }

            $number = SipDevices::model()->findByAttributes(['chained_user_id' => $operator_id])->name;

            $this->_openConnection();
            $this->_transfer($call->cid_chan, $number);
            $answer = $this->_readAnswer();
            $this->_closeConnection();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    /**
     * Включение режима подслушивания по id звонка
     *
     * @param $call_id
     * @throws Exception
     */
    public function callOverhear($call_id)
    {
        try {
            $call = GroupCallRealtime::model()->findByPk($call_id);
            if (is_null($call)) {
                throw new Exception('Call is not found');
            }

            $ch_name = $call->cid_chan;
            $operator_number = SipDevices::model()->findByAttributes(['chained_user_id' => Yii::app()->user->getId()])->name;

            $this->_openConnection();
            $this->_overhear($operator_number, $ch_name);
            $answer = $this->_readAnswer();
            $this->_closeConnection();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    /**
     * Активация режима Мастер-Ученик
     *
     * @param $call_id
     * @throws Exception
     */
    public function callMaster($call_id)
    {
        // $operator_number — номера оператора, который нажимает на «Подслушать»
        // $ch_name — значение из БД group_call_realtime.cid_chan
        try {
            $call = GroupCallRealtime::model()->findByPk($call_id);
            if (is_null($call)) {
                throw new Exception('Call is not found');
            }

            $op_chan = $call->op_chan;
            $operator_number = SipDevices::model()->findByAttributes(['chained_user_id' => Yii::app()->user->getId()])->name;

            $this->_openConnection();
            $this->_master($operator_number, $op_chan);
            $answer = $this->_readAnswer();
            $this->_closeConnection();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

?>
