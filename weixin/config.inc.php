<?php

/*$config['db']['hostname'] = 'localhost';
$config['db']['dbname'] = 'tzbwx';
$config['db']['username'] = 'root';
$config['db']['password'] = 'Abcd1234';*/

define('DB_HOST', SAE_MYSQL_HOST_M);
define('DB_NAME', SAE_MYSQL_DB);
define('DB_USER', SAE_MYSQL_USER);
define('DB_PASS', SAE_MYSQL_PASS);
define('DB_PORT', SAE_MYSQL_PORT);
define('SITE_ROOT', 'http://littlenut.sinaapp.com/weixin');

$config['wx']['token'] = 'tzb';
$config['wx']['appid'] = 'wx0a4f24cf8a9fddc4';
$config['wx']['appsecret'] = '45997c2a424f63809cdbec5c22d0b3b2';

$config['dianping']['appKey'] = '08857334';
$config['dianping']['appSecret'] = '388ca1060b0b4aaf83dd81f4a9288adf';
$config['dianping']['apiUrl'] = 'http://api.dianping.com/v1/business/find_businesses';
