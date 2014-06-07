<?php

define('BASEPATH', dirname(__FILE__));

require(BASEPATH . '/class/wechat.class.php');
require(BASEPATH . '/config.inc.php');
require (BASEPATH . '/class/run.class.php');

function __autoload($class_name) {
    require(BASEPATH . '/class/' . $class_name . '.class.php');
}

$options = $config['wx'];
$weObj = new Wechat($options);
//$weObj->valid();
$weObj->getRev();

$weRun = new WechatRun($weObj, &$config);
$type = $weObj->getRevType();
switch ($type) {
    case Wechat::MSGTYPE_TEXT:
        $weRun->onText();
        break;
    case Wechat::MSGTYPE_EVENT:
        break;
    case Wechat::MSGTYPE_IMAGE:
        break;
    case Wechat::MSGTYPE_LOCATION:
        $weRun->onLocation();
        break;
    default:
        $weObj->text("help info")->reply();
}

