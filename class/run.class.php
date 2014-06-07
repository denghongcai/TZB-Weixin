<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class WechatRun {

    const TIME_LENGTH = 600;

    private $weObj;
    private $config;
    private $fakeid;
    private $user = false;  //包括fakeid, state, time
    private $ctime;

    public function __construct(&$weObj, &$config) {
        $this->weObj = $weObj;
        $this->config = $config;
        $this->fakeid = $weObj->getRevFrom();
        $this->ctime = time();
        $uid = md5($this->fakeid);
        session_id($uid);
        session_start();
        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            if (isset($user['time']) && $user['time'] + self::TIME_LENGTH > $this->ctime && $this->fakeid == $user['fakeid']) {
                $this->user = $user;
            } else {
                unset($_SESSION['user']);
            }
        }
    }

    public function onSubscribe() {
        
    }

    public function onUnsubscribe() {
        
    }

    public function onText() {
        $content = $this->weObj->getRevContent();
        switch ($content) {
            case '下一页':
                if ($this->user && $this->user['state'] == 'Dianping') {
                    $data = $this->user['Dianping'];
                    $dpObj = new Dianping($this->weObj, $this->config['dianping'], $data['x'], $data['y'], $data['page'] + 1);
                    if ($dpObj->doDianping()) {
                        exit;
                    }
                }
                break;
            
            default :
                $voteObj = new WechatVote($this->weObj);
                if ($voteObj->doVote()) {
                    exit;
                }
        }

        

        $this->weObj->text("hello, I'm wechat")->reply();
        exit;
    }

    public function onLocation() {
        $location = $this->weObj->getRevGeo();
        $dpObj = new Dianping($this->weObj, $this->config['dianping'], $location['x'], $location['y']);
        if ($dpObj->doDianping()) {
            $user['fakeid'] = $this->fakeid;
            $user['time'] = $this->ctime;
            $user['state'] = 'Dianping';
            $user['Dianping'] = array(
                'x' => $location['x'],
                'y' => $location['y'],
                'page' => 1,
            );
            $_SESSION['user'] = serialize($user);
            
            exit;
        }
    }

}
