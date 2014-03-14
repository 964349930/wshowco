<?php
/**
 * 配置文件
 * @author chen
 * @version 2014-03-11
 */
return array(
    'URL_MODEL' => 0,
    'URL_CASE_INSENSIIVE' => true,

    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'wshow',
    'DB_USER' => 'root',
    'DB_PWD' => '',
    'DB_PORT' => '3306',
    'DB_PREFIX' => 'ws_',

    'TMPL_L_DELIM' => '{',
    'TMPL_R_DELIM' => '}',

    'APP_GROUP_LIST' => 'home, mobile',
    'DEFAULT_GROUP' => 'home',

    'APP_AUTOLOAD_PATH' => '@.TagLib',
);
?>
