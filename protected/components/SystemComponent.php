<?php

class SystemComponent extends CApplicationComponent
{

    public $backupDir;
    public $backupPrefix;
    public $backupDateFormat;
    public $backupFolders;
    public $backupMysqlCdm;


    public function init()
    {
        $this->backupDir = Setting::getValue('backup_dir');
        $this->backupPrefix = Setting::getValue('backup_prefix');
        $this->backupDateFormat = Setting::getValue('backup_date_format');
        $this->backupFolders = explode(',', Setting::getValue('backup_paths'));
        $this->backupMysqlCdm = Setting::getValue('backup_mysql_cmd');

    }


    public function getMonitorData()
    {
        // uptime
        $uptimeData = exec('uptime');
        preg_match('/.*up (.*),  \d+ user/', $uptimeData, $uptime);
        $uptime = $uptime[1];

        // Load average
        $la = explode(' ', exec('cat /proc/loadavg'));

        // RAM status
        $fh = fopen('/proc/meminfo','r');
        $memoryTotal = 0;
        $memoryFree = 0;
        while ($line = fgets($fh)) {
            $data = [];
            if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $data)) {
                $memoryTotal = round($data[1] / 1024, 0);
                continue;
            }
            if (preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $data)) {
                $memoryFree = round($data[1] / 1024, 0);
                continue;
            }
        }
        fclose($fh);

        // HDD status
        exec('df -h', $hddData);
        $hdd = [];
        foreach ($hddData as $line) {
            if (strpos($line, '/dev/') !== false) {
                $hdd[] = explode(' ', preg_replace('/\s+/', ' ', $line));
            }
        }

        return [
            'ip' => $_SERVER['SERVER_ADDR'],
            'os' => exec('uname -a'),
            'uptime' => $uptime,
            'la' => $la[0] . ' / ' . $la[1] . ' / ' . $la[2],
            'ram_use' => $memoryTotal - $memoryFree,
            'ram_total' => $memoryTotal,
            'ram_use_percent' => round(100 * ($memoryTotal - $memoryFree) / $memoryTotal, 2),
            'hdd' => $hdd, // Filesystem  Size  Used  Avail  Use%  MountedOn
        ];
    }


    /**
     * В интерфейсе должны отображаться имеющиеся файлы бекапов с датой создания.
     */
    public function getBackupList()
    {
        if ( ! is_dir($this->backupDir)) {
            throw new Exception('Указанная папка для бэкапа не существует');
        }

        $dir = scandir($this->backupDir);

        $backups = [];
        foreach($dir as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $filePath = $this->getFilePath($file);

            if ( ! is_file($filePath)) {
                continue;
            }

            $backups[] = [
                'name' => $file,
                'path' => $filePath,
                'date' => date('Y-m-d H:m:i', filemtime($filePath)),
                'size' => filesize($filePath),
            ];
        }
        return $backups;
    }


    public function getFilePath($name)
    {
        $path = $this->backupDir . '/' . $name;

        // Возвращаем 404 если файла нет, или его настоящий путь не лежит в папке с бекапами
        if ( ! file_exists($path) || dirname(realpath($path)) != $this->backupDir) {
           // throw new CHttpException(404,'Файл не найден');
        }

        return $path;
    }


    /**
     * Должна быть возможность ручного запуска бекапа и удаление.
     * А также возможность запуска бекапа из крона.
     */
    public function createBackup()
    {
        $this->_collectMysql();

        $filePath = $this->backupDir . '/' . $this->backupPrefix . date($this->backupDateFormat) . '.tar.gz';
        exec('tar -cvf ' . $filePath . ' ' . implode(' ', $this->backupFolders));

        if ( ! file_exists($filePath) || filesize($filePath) == 0) {
            return false;
        }

        return true;
    }


    /**
     * @param $file
     */
    public function deleteBackup($file)
    {
        unlink($this->getFilePath($file));
    }


    /**
     * Получение дампа бд
     */
    protected function _collectMysql()
    {
        exec($this->backupMysqlCdm);
    }
}