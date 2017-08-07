<?php
/**
 * Created by PhpStorm.
 * User: cheerduck
 * Date: 09.07.2015
 * Time: 23:53
 */

class NotesSaverComponent extends CApplicationComponent
{
    protected $delimiter = ';';
    protected $dir_name = '';
    protected $base_path = '/tmp/callcenter/notes/';
    protected $filename_format = '{date}_{id}_{customer_phone}';

    protected $error;

    const ERROR_EMPTY_DELIMITER = 'Empty delimiter';
    const ERROR_EMPTY_FORMAT = 'Empty filename format';
    const ERROR_EMPTY_DIR_NAME = 'Empty directory name';
    const ERROR_EMPTY_DATA = 'No data for record';

    public function __construct()
    {
        if (isset(Yii::app()->params['save_notes_path'])) {
            $this->base_path = Yii::app()->params['save_notes_path'];
        }
    }

    public function saveNote($data, $id = '', $customer_phone = '')
    {
        $data = (array) $data;

        if (empty($data)) {
            $this->error = self::ERROR_EMPTY_DATA;
            return false;
        }

        if (empty($this->delimiter)) {
            $this->error = self::ERROR_EMPTY_DELIMITER;
            return false;
        }

        if (empty($this->dir_name)) {
            $this->error = self::ERROR_EMPTY_DIR_NAME;
            return false;
        }

        if (empty($this->filename_format)) {
            $this->error = self::ERROR_EMPTY_FORMAT;
            return false;
        }

        $filename = $this->filename_format;
        $filename = str_replace('{date}', date('YmdHis'), $filename);
        $filename = str_replace('{id}', $id, $filename);
        $filename = str_replace('{customer_phone}', $customer_phone, $filename);

        $delimiter = $this->delimiter;
        $delimiter = str_replace('\n', "\n", $delimiter);
        $delimiter = str_replace('\r', "\r", $delimiter);
        $delimiter = str_replace('\t', "\t", $delimiter);

        $data = implode($delimiter, $data) . "\n";

        $filename = $this->getDir() . $filename;
        return file_put_contents($filename, $data, FILE_APPEND);
    }

    public function getDir()
    {
        $path = $this->base_path . '/' . $this->dir_name . '/';
        return str_replace('//', '/', $path);
    }

    public function loadSettingFromGroup($group_id)
    {
        /** @var Group $group */
        $group = Group::model()->findByPk($group_id);
        if (empty($group)) {
            return false;
        }
        if (empty($group->is_save_notes)) {
            return false;
        }

        $this->delimiter = $group->save_notes_delimiter;
        $this->dir_name = $group->save_notes_path;
        $this->filename_format = $group->save_notes_file_format;
        return $this->createDir();
    }

    protected function createDir()
    {
        if (!file_exists($this->getDir())) {
            return mkdir($this->getDir(), 0777, true);
        }
        return true;
    }
}