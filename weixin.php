<?php
	define('BASEPATH', dirname(__FILE__));

	require_once(BASEPATH . '/class/wechat.class.php');
	require_once(BASEPATH . '/config.inc.php');
	
	function __autoload($class_name)
	{
	    require_once BASEPATH . '/class/' . $class_name . '.class.php';
	}

	/*function logdebug($text){
		file_put_contents('log/log.txt',$text."\n",FILE_APPEND);		
	};
	$options = array(
		'token'=>'tokenaccesskey', //填写你设定的key
		'debug'=>true,
		'logcallback'=>'logdebug'
	);*/
	$options = $config['wx'];
	$weObj = new Wechat($options);
	
	//$weObj->valid();
	$weObj->getRev();

	$type = $weObj->getRevType();
	switch($type) {
		case Wechat::MSGTYPE_TEXT:
			$voteObj = new WechatVote($weObj);
			if($voteObj->doVote())
				exit;

			$weObj->text("hello, I'm wechat")->reply();
			exit;
			break;
		case Wechat::MSGTYPE_EVENT:
			break;
		case Wechat::MSGTYPE_IMAGE:
			break;
		default:
			$weObj->text("help info")->reply();
	}

