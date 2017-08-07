<?php

?>

<table class="items table table-striped table-bordered table-condensed">
    <tr>
        <td>ip адрес сервера</td>
        <td><?=$data['ip']?></td>
    </tr>
    <tr>
        <td>версия ОС</td>
        <td><?=$data['os']?></td>
    </tr>
    <tr>
        <td>uptime</td>
        <td><?=$data['uptime']?></td>
    </tr>
    <tr>
        <td>средняя загрузка (за 1мин / 5мин / 15мин)</td>
        <td><?=$data['la']?></td>
    </tr>
    <tr>
        <td>использование оперативной памяти</td>
        <td><?=$data['ram_use']?>Mb / <?=$data['ram_total']?>Mb (<?=($data['ram_use_percent'])?>%)</td>
    </tr>
    <tr>
        <td>использование жесткого диска</td>
        <td>
            <table>
                <tr>
                    <th>Раздел на диске</th>
                    <th>Размер</th>
                    <th>Использовано</th>
                    <th>Доступно</th>
                    <th>Использовано (%)</th>
                    <th>Точка монтирования</th>
                </tr>
                <?php foreach ($data['hdd'] as $hdd) { ?>
                <tr>
                    <td><?=$hdd[0]?></td>
                    <td><?=$hdd[1]?></td>
                    <td><?=$hdd[2]?></td>
                    <td><?=$hdd[3]?></td>
                    <td><?=$hdd[4]?></td>
                    <td><?=$hdd[5]?></td>
                </tr>
                <?php } ?>
            </table>
        </td>
    </tr>

</table>

