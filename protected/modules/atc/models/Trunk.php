<?php

/**
 * Модель для таблицы "sip_devices".
 *
 * Доступные колонки в таблице 'sip_devices':
 * @property integer $id
 * @property string $username
 * @property string $fromuser
 * @property string $secret
 * @property string $host
 * @property string $fromdomain
 * @property string $port
 * @property string $dtmfmode
 * @property string $allow
 * @property string $nat
 * @property integer $is_need_registration
 * @property string $as_number
 */
class Trunk extends SipDevices
{
    const DATA_FILE_PATH='/etc/asterisk/sip_reg.conf';

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, username, fromuser, secret, fromdomain, context', 'length', 'max'=>80),
            array('insecure', 'length', 'max'=>40),
            array('host', 'length', 'max'=>31),
            array('port, nat', 'length', 'max'=>5),
            array('allow, disallow', 'length', 'max'=>100),
            array('dtmfmode', 'length', 'max'=>7),
            array('as_number', 'length', 'max'=>20),
            array('calllimit, is_need_registration', 'numerical', 'integerOnly'=>true),
            array('name, host, fromdomain', 'required'),
            array('id, username, fromuser, secret, fromdomain, host, port, nat, allow, dtmfmode, as_number, is_need_registration', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('application', 'ID'),
            'name' => Yii::t('application', 'Название'),
            'username' => Yii::t('application', 'Логин'),
            'secret' => Yii::t('application', 'Пароль'),
            'host' => Yii::t('application', 'Адрес'),
            'port' => Yii::t('application', 'Порт'),
            'nat' => Yii::t('application', 'NAT'),
            'allow' => Yii::t('application', 'Кодеки'),
            'as_number' => Yii::t('application', 'Регистрироваться как номер'),
            'is_need_registration' => Yii::t('application', 'Требуется регистрация'),
            'dtmfmode' => Yii::t('application', 'DTMF'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record класс.
     * @return SipDevices статический класс модели
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function defaultScope()
    {
        return [
            'condition' => "name LIKE 'trunk_%'",
        ];
    }

    public function updateDataFile()
    {
        $file = fopen(self::DATA_FILE_PATH, 'w');
        $trunks = self::model()->findAll();
        /** @var $trunk Trunk */
        foreach ($trunks as $trunk) {
            $line = "register=>{$trunk->username}:{$trunk->secret}@{$trunk->host}:{$trunk->port}";
            if (strlen($trunk->as_number) > 0) {
                $line .= "/{$trunk->as_number}";
            }
            $line .= "\n";
            fputs($file, $line);
        }
        fclose($file);
    }

    protected function afterValidate()
    {
        $check = preg_match('/^[a-zA-Z0-9]+$/', str_replace('trunk_', '', $this->name));
        if ($check == 0) {
            $this->addError('name', 'Название должно содержать только латинские буквы без пробелов');
            return false;
        }
        parent::afterValidate();
    }

}