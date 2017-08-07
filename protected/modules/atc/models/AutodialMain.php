<?php

/**
 * This is the model class for table "autodial_main".
 *
 * The followings are the available columns in table 'autodial_main':
 * @property string $id
 * @property string $name
 * @property string $dir
 * @property string $starttime
 * @property string $stoptime
 * @property string $worktimestart
 * @property string $worktimestop
 * @property string $exeption_day
 * @property string $predict_group
 * @property integer $predict_add_calls
 * @property integer $status
 * @property integer $iter
 * @property integer $callcount
 * @property integer $event
 * @property integer $value
 * @property integer $trunk_id
 * @property string $prefix
 * @property integer $regular
 * @property string $regular_time
 * @property integer $record
 * @property integer $success_dial
 * @property integer $success_sec
 * @property integer $iter_delay
 * @property string $callerid
 */
class AutodialMain extends CActiveRecord
{
    public $exeption_day_arr = [];
    public $exeption_day_list = [
        ['id' => 0, 'value' => 0, 'label' => 'вс'],
        ['id' => 1, 'value' => 0, 'label' => 'пн'],
        ['id' => 2, 'value' => 0, 'label' => 'вт'],
        ['id' => 3, 'value' => 0, 'label' => 'ср'],
        ['id' => 4, 'value' => 0, 'label' => 'чт'],
        ['id' => 5, 'value' => 0, 'label' => 'пт'],
        ['id' => 6, 'value' => 0, 'label' => 'сб'],
    ];
    public $status_list = [
        0 => 'stopped',
        1 => 'started',
        2 => 'paused',
    ];

    public $success_dial_list = [
        1 => "Отвечен",
        2 => "Прослушано сек.",
        3 => "Прослушано полностью",
    ];

    public $is_predict;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'autodial_main';
    }

    public function rules()
    {
        return array(
            array('name, iter, callcount, event, trunk_id', 'required'),
            array('is_predict, predict_group, predict_add_calls, status, value, regular, record, success_dial, success_sec, iter_delay', 'numerical', 'integerOnly' => true),
            array('iter', 'numerical', 'integerOnly' => true, 'min' => 1, 'tooSmall' => 'Кол-во повторений слишком мал (Минимум: 1).'),
            array('callcount', 'numerical', 'integerOnly' => true, 'min' => 1, 'tooSmall' => 'Кол-во одновременных вызовов слишком мало (Минимум: 1).'),
            array('event', 'numerical', 'integerOnly' => true, 'min' => 1, 'tooSmall' => 'Не выбрано событие'),
            array('trunk_id', 'numerical', 'integerOnly' => true, 'min' => 1, 'tooSmall' => 'Не выбран транк'),
            array('name', 'length', 'max' => 255),
            array('dir, prefix, callerid', 'length', 'max' => 60),
            array('worktimestart, worktimestop', 'length', 'max' => 8),
            array('regular_time', 'length', 'max' => 5),
            array('exeption_day', 'length', 'max' => 13),
            array('starttime, stoptime, exeption_day_arr', 'safe'),
            array('id, dir, starttime, stoptime, worktimestart, worktimestop, exeption_day, predict_group, predict_add_calls, status, iter, callcount, event, value, trunk_id, prefix', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id'                => 'ID',
            'name'              => 'Название',
            'dir'               => 'Директория для записей разговоров',
            'starttime'         => 'Начало обзвона',
            'stoptime'          => 'Конец обзвона',
            'worktimestart'     => 'Допустимое время звонка "С" (ЧЧ:ММ)',
            'worktimestop'      => 'Допустимое время звонка "По" (ЧЧ:ММ)',
            'exeption_day'      => 'Дни исключений',
            'predict_group'     => 'Служба для предикта',
            'predict_add_calls' => 'Коэфф. ускорения для предикта',
            'status'            => 'Статус задания',
            'iter'              => 'Кол-во попыток',
            'callcount'         => 'Кол-во одновременных вызовов',
            'event'             => 'Событие',
            'value'             => 'Значение',
            'trunk_id'          => 'Транк',
            'prefix'            => 'Префикс',
            'is_predict'        => 'Предиктивный автообзвон',
            'regular'           => 'Регулярное задание',
            'regular_time'      => 'Время ругулярного задания',
            'record'            => 'Записывать разговоры',
            'success_dial'      => 'Успешность дозвона', //  ("Отвечен" - 1, "Прослушано сек." - 2, "Прослушано полностью" - 3)
            'success_sec'       => 'Прослушано сек',
            'iter_delay'        => 'Интервалы повторений (мин)',
            'callerid'          => 'Внешний номер',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('dir', $this->dir, true);
        $criteria->compare('starttime', $this->starttime, true);
        $criteria->compare('stoptime', $this->stoptime, true);
        $criteria->compare('worktimestart', $this->worktimestart, true);
        $criteria->compare('worktimestop', $this->worktimestop, true);
        $criteria->compare('exeption_day', $this->exeption_day, true);
        $criteria->compare('predict_group', $this->predict_group, true);
        $criteria->compare('predict_add_calls', $this->predict_add_calls);
        $criteria->compare('status', $this->status);
        $criteria->compare('iter', $this->iter);
        $criteria->compare('callcount', $this->callcount);
        $criteria->compare('event', $this->event);
        $criteria->compare('value', $this->value);
        $criteria->compare('trunk_id', $this->trunk_id);
        $criteria->compare('prefix', $this->prefix, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave()
    {
        if (!parent::beforeSave()) {
            return false;
        }

        if (empty($this->is_predict)) {
            $this->predict_group = 0;
            $this->predict_add_calls = 0;
        }

        if (!empty($this->regular) && empty($this->regular_time)) {
            $this->addError('regular_time', 'Вы должны указать время для регулярного задания');
            return false;
        }

        if ($this->success_dial == 2 && empty($this->success_sec)) {
            $this->addError('success_sec', 'Вы должны указать количество секунд');
            return false;
        }

        $this->exeption_day = implode(',', array_keys($this->exeption_day_arr));

        if (!$this->record) {
            return true;
        }

        $dir = Yii::app()->params['autodialDir'] . $this->dir;
        if (is_dir($dir)) {
            return true;
        }

        if (mkdir($dir, 0777, true)) {
            if (chmod($dir, 0777)) {
                return true;
            } else {
                $this->addError('dir', 'Не удалось изменить права для директории ' . $dir);
                return false;
            }
        } else {
            $this->addError('dir', 'Не удалось создать директорию ' . $dir);
            return false;
        }
    }

    protected function beforeDelete()
    {
        AutodialNumbers::model()->deleteAllByAttributes(['autodialid' => $this->id]);
        $dir = Yii::app()->params['autodialDir'] . $this->dir;
        $files = glob($dir . "/*");
        if ($files) {
            foreach($files as $file) {
                unlink($file);
            }
        }
        rmdir($dir);
        return true;
    }

    public function getProcess()
    {
        $Db = $this->getDbConnection();
        $all = $Db->createCommand('SELECT COUNT(*) FROM ' . AutodialNumbers::model()->tableName() . ' WHERE autodialid = ' . intval($this->id));
        $ready = $Db->createCommand('SELECT COUNT(*) FROM ' . AutodialNumbers::model()->tableName() . ' WHERE autodialid = ' . intval($this->id) . ' AND status = 1');
        return $ready->queryScalar() . '/' . $all->queryScalar();
    }

    /**
     * Проверяем была ли хотя бы у обного номера попытка дозвона
     */
    public function checkStarterNumbers()
    {
        $data = AutodialNumbers::model()->findByAttributes(['autodialid' => $this->id, 'status' => [1,2]]);
        if (empty($data)) {
            return false;
        }

        return true;
    }

    public function playFromStart()
    {
        $Db = $this->getDbConnection();
        $Db->createCommand("UPDATE autodial_numbers SET iter=" . $this->iter . ", status=0 WHERE autodialid=" . $this->id)->execute();
        $this->status = 1;
        $this->save();
    }
}
