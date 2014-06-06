<?php
	define('BASEPATH', dirname(__FILE__));

	require(BASEPATH . '/class/wechat.class.php');
	require(BASEPATH . '/config.inc.php');
	
	function __autoload($class_name)
	{
	    require(BASEPATH . '/class/' . $class_name . '.class.php');
	}

	$options = $config['wx'];
	$weObj = new Wechat($options);
	
	//$weObj->valid();
	$weObj->getRev();

	$type = $weObj->getRevType();
	switch($type) {
		case Wechat::MSGTYPE_TEXT:
			$voteObj = new WechatVote($weObj );
			if($voteObj->doVote())
				exit;

			$weObj->text("hello, I'm wechat")->reply();
			exit;
			break;
		case Wechat::MSGTYPE_EVENT:
			break;
		case Wechat::MSGTYPE_IMAGE:
			break;
		case Wechat::MSGTYPE_LOCATION:
			$location = $weObj->getRevGeo();
			$dpObj = new Dianping($weObj, $config['dianping'], $location['x'], $location['y']);
			if($dpObj->doDianping())
				exit;
			break;
		default:
			$weObj->text("help info")->reply();
	}

