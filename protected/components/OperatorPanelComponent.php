<?php

class OperatorPanelComponent extends CApplicationComponent
{
    const CACHE_PREFIX = 'OpPanel_data';
    const CACHE_PREFIX_USER = 'OpPanel_statistic_';
    const CACHE_EXPIRE_TIME = 60;

    protected $userOnlineIds;

    /**
     * Обновление информации на панели оператора
     * Возвращает все данные по модели если ничего небыло передано
     * или только данные по конкретному пользователю, если было передано ['user_login' => 22]
     *
     * @param array $params
     * @param bool $resetCache
     * @return array
     */
    public function getMonitorData($params = [], $resetCache = false)
    {
        $result = Yii::app()->cache->get(self::CACHE_PREFIX);
        if ($result === false || $resetCache) {
            $result = $this->_generateData($params);
        }
        $result = $this->_getDataForUser($result, Yii::app()->user->getId());

        return $result;
    }

    protected function _generateData($params)
    {
        $result = [
            'noteForms' => [],
            'queues'    => [],
            'online'    => [],
        ];

        $newUser = (array_key_exists('user_login', $params) && !empty($params['user_login'])) ? intval($params['user_login']) : null;

        $userIds = $this->_getOnlineUserIds($newUser);
        if (empty($userIds)) {
            return $result;
        }
        $userIdsToInClause = implode(',', $userIds);

        $sql = <<<SQL
SELECT distinct
       g.id,
       g.name,
       g.icon
  FROM group_users gu
  JOIN `group` g ON gu.group_id = g.id
 WHERE gu.user_id IN ($userIdsToInClause)
   AND g.deleted = 0
 ORDER BY g.name
SQL;

        $groups = Yii::app()->db->createCommand($sql)->queryAll();

        $sql = <<<SQL
SELECT DISTINCT
       IF(u.id IS NULL, -1, gcr.status) as status,
       IF(u.surname IS NULL AND u.firstname IS NULL, '', CONCAT(u.surname, ' ', u.firstname)) as user_fio,
       IFNULL(us.icon, '') as user_icon,
       gcr.id,
       gcr.time_in,
       gcr.time_ans,
       gcr.linkedid,
       gcr.group_id,
       gcr.user_id,
       IFNULL(v.name, gcr.cid) as vip_name,
       IFNULL(g.color, '') as group_color,
       g.name as group_name,
       g.is_need_notes
  FROM group_call_realtime gcr
  LEFT JOIN `group` g ON gcr.group_id = g.id
  LEFT JOIN vip v ON v.tel1 = gcr.cid
  LEFT JOIN user u ON gcr.user_id = u.id
  LEFT JOIN user_status us ON u.status = us.id
WHERE gcr.status in (0 , 1) and gcr.group_id = :group_id
ORDER BY if(gcr.user_id = 0, 0, 1), gcr.time_in
SQL;

        foreach ($groups as $group) {
            $gcrs = Yii::app()->db->createCommand($sql)->queryAll(true, [':group_id' => $group['id']]);

            $calls = [];
            foreach ($gcrs as $call) {
                $calls[] = [
                    'id'       => $call['id'],
                    'phone'    => $call['vip_name'],
                    'color'    => $call['group_color'],
                    'time'     => strtotime($call['time_in']) * 1000,
                    'status'   => $call['status'],
                    'operator' => $call['user_fio'],
                    'icon'     => $call['user_icon'],
                ];

                if ($call['status'] == '1' && $call['is_need_notes'] == '1') {
                    $fields     = [];
                    $sqlNF      = "SELECT DISTINCT nf.id, nf.name, nf.field_type, nf.is_important, nf.options FROM notes n LEFT JOIN note_field nf ON nf.group_id = n.id WHERE n.groupId = :groupId order by nf.sort ASC";
                    $noteFields = Yii::app()->db->createCommand($sqlNF)->queryAll(true, [':groupId' => $call['group_id']]);
                    if (!empty($noteFields)) {
                        foreach ($noteFields as $noteField) {
                            $fields[$noteField['id']] = [
                                'name' => $noteField['name'],
                                'type' => $noteField['field_type'],
                                'require' => $noteField['is_important'],
                                'options' => $noteField['options'],
                            ];
                        }
                        $linkedid = str_replace('.', '-', $call['linkedid']);
                        $form     = CController::renderInternal(
                            __DIR__ . '/views/OperatorPanel/_noteForm.php',
                            [
                                'fields' => $fields,
                                'id' => $linkedid,
                                'group_id' => $call['group_id'],
                                'cid' => $call['vip_name'],
                            ],
                            true
                        );

                        $result['noteForms'][] = [
                            'linkedid' => $linkedid,
                            'user_id'  => $call['user_id'],
                            'color'    => $call['group_color'],
                            'title'    => $call['vip_name'] . '|' . $call['group_name'],
                            'time'     => date('Y/m/d H:i:s', strtotime($call['time_ans'])),
                            'form'     => $form,
                        ];
                    }
                }
            }
            $result['queues'][] = [
                'group_id' => $group['id'],
                'title'    => $group['name'],
                'icon'     => Group::getIconUrl($group['icon']),
                'calls'    => $calls,
                'expanded' => 1,
            ];
        }

        $sql = <<<SQL
SELECT u.id,
       group_concat(g.group_id) as groups,
	   CONCAT(u.surname, ' ', u.firstname) as user_fio,
	   IF(sd.name IS NULL, '', CONCAT('(', sd.name, ')')) as sd_name,
       IFNULL(us.id, 1) as status_id, -- если статуса у пользователя нет, назчит он только зашел, значит ему присвоится "Онлайн"
       IFNULL(us.icon, '') as status_icon
FROM user u
JOIN group_users g ON g.user_id = u.id
LEFT JOIN sip_devices sd ON sd.chained_user_id = u.id AND sd.name NOT LIKE 'trunk_%'
LEFT JOIN user_status us ON u.status = us.id
WHERE u.id in ($userIdsToInClause)
GROUP BY u.id
ORDER BY u.surname , u.firstname
SQL;

        $tmpResult = Yii::app()->db->createCommand($sql)->queryAll();

        $sql = <<<SQL
SELECT gcr.id,
	   IFNULL(v.name, gcr.cid) as vip,
       gcr.status,
	   gcr.time_in,
	   g.color AS group_color,
	   g.name AS group_name,
	   g.icon AS group_icon
FROM group_call_realtime gcr
LEFT JOIN vip v ON v.tel1 = gcr.cid
LEFT JOIN `group` g ON gcr.group_id = g.id
WHERE status in (0, 1) and user_id = :user_id
ORDER BY g.name, v.name, gcr.cid
SQL;

        foreach ($tmpResult as $user) {
            $gcrs   = Yii::app()->db->createCommand($sql)->queryAll(true, [':user_id' => $user['id']]);
            $calls  = [];
            $status = -1;
            foreach ($gcrs as $call) {
                $calls[] = [
                    'id'     => $call['id'],
                    'phone'  => $call['vip'],
                    'color'  => $call['group_color'],
                    'time'   => strtotime($call['time_in']) * 1000,
                    'group'  => $call['group_name'],
                    'status' => $call['status'],
                    'icon'   => Group::getIconUrl($call['group_icon']),
                ];

                if ($status < $call['status']) {
                    $status = $call['status'];
                }
            }

            $result['online'][] = [
                'user_id'     => $user['id'],
                'group_ids'   => explode(',', $user['groups']),
                'name'        => $user['user_fio'] . $user['sd_name'],
                'status'      => $status,
                'user_status' => $user['status_id'],
                'icon'        => $user['status_icon'],
                'calls'       => $calls,
            ];
        }

        Yii::app()->cache->set('OpPanel_data', $result, self::CACHE_EXPIRE_TIME);

        // Рассылаем уведомления клиентам об изменении данных
        foreach ($userIds as $val) {
            Yii::app()->comet->push(['user_' . $val . '/op_data'], ['type' => 'opPanel_update']);
        }

        return $result;
    }

    protected function _getOnlineUserIds($newUser = null)
    {
        if (!empty($this->userOnlineIds)) {
            return $this->userOnlineIds;
        }

        $sessions = UserSession::model()->findAll();
        $ids      = [];

        if (!is_null($newUser)) {
            $ids[] = $newUser;
        }

        foreach ($sessions as $session) {
            $aSession = Session::unserialize($session['data']);
            foreach ($aSession as $key => $value) {
                if (strstr($key, '__id')) {
                    $ids[] = intval($value);
                }
            }
        }
        $ids = array_unique($ids);

        return $this->userOnlineIds = $ids;
    }

    /**
     * Возвращает cometSid для прослушавания канала вида user_XX
     *
     * @param null|integer $userId
     * @return mixed
     */
    public function getUserCometSid($userId = null)
    {
        if (empty($userId)) {
            $userId = Yii::app()->user->getId();
        }

        return Yii::app()->comet->getSessionId(['user_' . $userId]);
    }

    /**
     * Возвращаем данные на основании переданного пользователя
     * Фильтрует данные в зависимости от уровню доступа (роли + нахождение в группах)
     *
     * @param $result
     * @param $userId
     * @return mixed
     */
    protected function _getDataForUser($result, $userId)
    {
        // определяем группы, которые должен видеть пользователь в "очереди"
        $groups = null;
        if (!Yii::app()->getAuthManager()->checkAccess('viewAllServicesCalls', $userId)) {
            $groups = Yii::app()->user->getState('groupId');
        }

        if (!empty($result['noteForms'])) {
            foreach ($result['noteForms'] as $key => $val) {
                if ($userId != $val['user_id']) {
                    unset($result['noteForms'][$key]);
                }
            }
        }

        if (!empty($result['queues']) && is_array($groups)) {
            foreach ($result['queues'] as $key => $val) {
                if (!in_array($val['group_id'], $groups)) {
                    unset($result['queues'][$key]);
                    continue;
                }
            }
        }

        // подсчет кол-ва звонков в разных статусах
        if (!empty($result['queues'])) {
            foreach ($result['queues'] as $key => $val) {
                $statusCount = [
                    'is_active'    => 0,
                    'is_waiting'   => 0,
                    'is_no_active' => 0,
                ];
                foreach ($val['calls'] as $call) {
                    switch ($call['status']) {
                        case '-1':
                            $statusCount['is_no_active']++;
                            break;
                        case '0':
                            $statusCount['is_waiting']++;
                            break;
                        case '1':
                            $statusCount['is_active']++;
                            break;
                        default:
                    }
                }
                $result['queues'][$key] = array_merge($result['queues'][$key], $statusCount);
            }
        }

        if (!empty($result['online'])) {
            foreach ($result['online'] as $key => $val) {
                $result['online'][$key]['is_current'] = $result['online'][$key]['user_id'] == $userId;
            }
        }

        $result['currentTime'] = date('Y/m/d H:i:s', time());
        $result['groups'] = $groups;

        return $result;
    }

    public function getStatistics()
    {
        $userId = Yii::app()->user->getId();

        $result = Yii::app()->cache->get(self::CACHE_PREFIX_USER . $userId);
        if ($result === false) {
            $curDate = date('Y-m-d');
            $nextDate = date("Y-m-d", strtotime("+1 day"));
            $queryCommon = "user_id = $userId AND time_in > '$curDate'";

            $served = Yii::app()->db->createCommand("SELECT count(*) FROM callcenter.call_log WHERE status = 1 AND $queryCommon")->queryScalar();
            $noServed = Yii::app()->db->createCommand("SELECT count(*) FROM callcenter.call_log WHERE status = 0 AND NOT (length(dest) > length(cid) and length(cid) = 3) AND $queryCommon")->queryScalar();
            $distributed = $served + $noServed;
            $percent_served = round(($served == 0 ? 0 : 100 * $served / ($served + $noServed)), 2) . '%' ;

            $sql = <<<SQL
SELECT SUM(online_time) as online_time, SUM(lunch_time) as lunch_time FROM (
-- completed time
SELECT
    if (status_id = 1, unix_timestamp(date_end) - unix_timestamp(if (date_start > '$curDate', date_start, '$curDate')), 0) as online_time,
	if (status_id = 2, unix_timestamp(date_end) - unix_timestamp(if (date_start > '$curDate', date_start, '$curDate')), 0) as lunch_time
FROM
    callcenter.status_log
WHERE status_id in (1, 2)
  AND date_end between '$curDate' and '$nextDate'
  AND user_id = $userId
UNION
-- current time
SELECT
    if (status_id = 1, unix_timestamp(NOW()) - unix_timestamp(if (date_start > '$curDate', date_start, '$curDate')), 0) as online_time,
    if (status_id = 2, unix_timestamp(NOW()) - unix_timestamp(if (date_start > '$curDate', date_start, '$curDate')), 0) as lunch_time
FROM
    callcenter.status_log
WHERE status_id in (1, 2)
  AND date_end is null
  AND user_id = $userId
) t
SQL;
            $times = Yii::app()->db->createCommand($sql)->queryRow();
            $online_time = gmdate("H:i:s", $times['online_time']);
            $lunch_time = gmdate("H:i:s", $times['lunch_time']);

            $result = [
                'distributed' => $distributed, //'распределено вызовов (оранжевый)',
                'no_served' => $noServed, //'обслужено вызовов (зеленый)',
                'served' => $served, //'необслужено вызовов (красный)',
                'percent_served' => $percent_served, //'процент обслуженных вызовов (черный)',
                'online_time' => $online_time, //'время работы в системе (зеленый)',
                'lunch_time' => $lunch_time, //'время на обеде (оранжевый)',
            ];

            Yii::app()->cache->set(self::CACHE_PREFIX_USER . $userId, $result, Setting::getValue('cache_user_statistics_expire'));
        }
        return $result;
    }
}
