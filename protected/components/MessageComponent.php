<?php

class MessageComponent extends CApplicationComponent
{
    public function sendMessage(array $data) {
//        [
//            'title' => 'Заголовок',
//            'body' => 'Текст сообщения',
//            'type' => '1', // 1 - user_id, 2 - group_id, 3 - all users
//            'receiver_id' => '22',
//        ]
        try {
            $msg = new Message;
            $msg->title = $data['title'];
            $msg->body = $data['body'];
            $msg->type = $data['type'];
            $msg->user_id = Yii::app()->user->getId();
            $transaction = $msg->getDbConnection()->beginTransaction();
            $msg->save();
            switch ($data['type']) {
                case '1': // personal user
                    $msgUser = new MessageUser;
                    $msgUser->message_id = $msg->id;
                    $msgUser->user_id = $data['receiver_id'];
                    $msgUser->save();
                    break;
                case '2': // group users
                    $users = GroupUsers::model()->findAllByAttributes(['group_id' => $data['receiver_id']]);
                    if (empty($users))
                        throw new Exception('Данная группа не содержит пользователей');
                    foreach ($users as $row) {
                        $msgUser = new MessageUser;
                        $msgUser->message_id = $msg->id;
                        $msgUser->user_id = $row['user_id'];
                        $msgUser->save();
                    }
                    break;
                case '3': // all users
                    $users = User::model()->findAll();
                    if (empty($users))
                        throw new Exception('Пользователи не найдены');
                    foreach ($users as $row) {
                        $msgUser = new MessageUser;
                        $msgUser->message_id = $msg->id;
                        $msgUser->user_id = $row['id'];
                        $msgUser->save();
                    }
                    break;
                default:
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function setViewedStatus($message_id, $user_id = null) {
        if (is_null($user_id))
            $user_id = Yii::app()->user->getId();
        /** @var MessageUser $msg */
        $msg = MessageUser::model()->findByAttributes(['message_id' => $message_id, 'user_id' => $user_id]);
        if (!empty($msg)) {
            $msg->status = 1;
            $msg->save();
        }
    }
}