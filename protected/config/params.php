<?php
return array(
    // this is used in contact page
    'adminEmail' => 'romanoza@gmail.com',
    'uploadDir' => '/var/lib/asterisk',
    'soundsDir' => '/var/lib/asterisk/sounds',
    'mohDir' => '/var/lib/asterisk/sounds',
    'autodialDir' => '/var/spool/asterisk/',
    'ivrDir' => 'ivr',
    'groupIconDir' => $_SERVER['DOCUMENT_ROOT'] . '/protected/data/files/service_icons',
    'ami' => array(
        'host' => '127.0.0.1',
        'port' => '5038',
        'amiuser' => 'call_manager',
        'amipassword' => 'call_manager',
    ),
    'save_notes_path' => $_SERVER['DOCUMENT_ROOT'] . '/protected/data/saved_notes',
);
?>
