<?php
date_default_timezone_set('PRC');

return new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'aa',
        'dbname' => 'bbs_db'
    ),
    'application' => array(
        'controllersDir' => APP_DIR . '/controllers/',
        'modelsDir' => APP_DIR . '/models/',
        'formsDir' => APP_DIR . '/forms/',
        'viewsDir' => APP_DIR . '/views/',
        'libraryDir' => APP_DIR . '/library/',
        'pluginsDir' => APP_DIR . '/plugins/',
        'cacheDir' => APP_DIR . '/cache/',
        'baseUri' => '/',
        'publicUrl' => '',
        'cryptSalt' => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D',
        'documentDir'=>APP_DIR.'/doc/',
        'uploadDir'=>BASE_DIR.'/public/chat_file/upload/',
        'uploadPublic'=>'/public/chat_file/upload/',
        //ÎÄ¼þ±¸·ÝÂ·¾¶
        'chat_backup'=>BASE_DIR.'/public/chat_file/backup/',
        'docDir'=>'app/doc/'
    ),
    'redis'=>array(
        'host'=>'127.0.0.1',
        'port'=>'6379',
    ),
    'log'=>array(
        'path'=>BASE_DIR."/logs/bbs.log",
    )
));
