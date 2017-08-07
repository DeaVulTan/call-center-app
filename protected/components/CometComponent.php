<?php

/**
 * Class CometComponent
 */
class CometComponent extends CApplicationComponent
{
    /**
     * Хост комет-сервера
     *
     * @var string
     */
    public $host;

    /**
     * Порт комет-сервера
     *
     * @var string
     */
    public $port;

    /**
     * Таймаут пуша сообщения в комет-сервер
     *
     * @var int
     */
    public $timeout = 1;

    /**
     * Получение идентификатора сессии комета
     * Используется для доступа к авторизованным каналам комета.
     * Для каналов с префиксом pub авторизация не требуется.
     *
     * @param array $channelPrefixList Список префиксов разрешенных каналов для данной сессии
     * @param string $secretKey Соль для хеширования списка префиксов каналов,
     *                          устанавливается при запуске демона комет-сервера
     *
     * @return string
     */
    public function getSessionId(array $channelPrefixList = array(), $secretKey = 'SECRETKEY')
    {
        $encodedPrefixList = base64_encode(implode(':', $channelPrefixList));
        $hash              = md5($encodedPrefixList . ':' . $secretKey);
        $value             = $encodedPrefixList . '--' . $hash;
        return $value;
    }

    /**
     * Список каналов
     *
     * @return string
     */
    public function getChannelsList()
    {
        $channels = ['public'];
        return implode(',', $channels);
    }

    /**
     * Передача сообщения в комет-сервер
     *
     *
     * @param array $channelsList
     * @param array $body - массив тела сообщения, должен быть валидный ассоциативный массив
     * который после кодирования в json станет js-обьектом
     * @return bool
     *
     * @throws CometException
     */
    public function push(array $channelsList,array $body)
    {
        $url = "http://{$this->host}:{$this->port}/push";

        $post = [
            'channels' => implode(',', $channelsList),
            'body'     => CJavaScript::jsonEncode($body),
            'cometsid' => $this->getSessionId($channelsList)
        ];

        $curlHandler = curl_init();
        $params      = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_NOBODY         => false,
            CURLOPT_POSTFIELDS     => is_array($post)
                    ? http_build_query($post)
                    : [],
            CURLOPT_POST           => is_array($post),
            CURLOPT_FAILONERROR    => true,
            CURLOPT_TIMEOUT        => $this->timeout
        ];
        curl_setopt_array($curlHandler, $params);
        $result = curl_exec($curlHandler);



        if (!$result) {

            Yii::log(
                $url . ': ' . curl_errno($curlHandler) . ' ' . curl_error($curlHandler),
                CLogger::LEVEL_WARNING,
                'PUSH_SERVER'
            );
            return false;
        }

        $seq = CJavaScript::jsonDecode($result);
        if(!is_array($seq) || !isset($seq['seq'])){
            $resultTrace = CVarDumper::dumpAsString($result);
            Yii::log(
                "Push result '{$resultTrace}' is not valid",
                CLogger::LEVEL_WARNING,
                'PUSH_SERVER'
            );
            return false;

        }

        $postTrace = CVarDumper::dumpAsString($post);
        Yii::trace(
            "Сообщение с полями {$postTrace} отправлено. Ответ сервера - ({$result})",
            'PUSH_SERVER'
        );

        return true;

    }

    /**
     * Проверка работоспособности комет-сервера
     */
    public function check()
    {
        return $this->push(['pub/check'], ['ok'=>'ok']);
    }

    /**
     * Статистика и информация о работе комет-сервера
     *
     * Данные с префиксом poll_* на данный момент сервером не отдаются
     *
     * @throws CometException
     * @return array
     * [
     *      "sessions"        - Общее количество сессий на комет сервере
     *      "sessions_ws"     - Количество сессий с транспортом - websocket
     *      "sessions_sse"    - Количество сессий с транспортом - sse (server sent events)
     *      "subscriptions"   - Количество подписок на каналы
     *
     *      "history_channels"- (?)
     *      "history_count"   - (?)
     *      "history_memory"  - (?)
     *
     *      "push_count5"     - Запушено за последние 5 секунд
     *      "push_count60"    -          за последнюю минуту
     *      "push_count3600"  -          за последний час
     *
     *      "poll_count5"     - Отправленно в каналы за последние 5 секунд
     *      "poll_count60"    -                      за последнюю минуту
     *      "poll_count3600"  -                      за последний час
     *  ]
     */
    public function getStats(){
        $url = "http://{$this->host}:{$this->port}/cometapi/stats";

        $curlHandler = curl_init();
        $params      = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_TIMEOUT        => $this->timeout
        ];
        curl_setopt_array($curlHandler, $params);
        $result = curl_exec($curlHandler);

        if(!$result){
            throw new CometException('Cannot obtain data from comet stats');
        }
        $stats = CJavaScript::jsonDecode($result);

        if(!is_array($stats)){
            throw new CometException('Invalid data from comet stats');
        }
        return $stats;
    }

    /**
     * Список всех сессий комет-сервера
     *
     * @throws CometException
     * @return array
     * [
     *     [
     *         "type": "websocket", - тип транспорта
     *         "channels": [        - список каналов, которые слушает данная сессия
     *             "pub/channel1",
     *             "msg/all"
     *          ]
     *     ],
     *     ...
     * ]
     *
     */
    public function getSessions(){
        $url = "http://{$this->host}:{$this->port}/sessions";

        $curlHandler = curl_init();
        $params      = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_TIMEOUT        => $this->timeout
        ];
        curl_setopt_array($curlHandler, $params);
        $result = curl_exec($curlHandler);

        if(!$result){
            throw new CometException('Cannot obtain data from comet sessions list');
        }
        $sessions = CJavaScript::jsonDecode($result);

        if(!is_array($sessions)){
            throw new CometException('Invalid data from comet sessions list');
        }
        return $sessions;
    }

    /********************************************
     *         Высокоуровневые функции          *
     ********************************************/

    
}

class CometException extends CException{}