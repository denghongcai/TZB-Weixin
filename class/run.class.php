<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require(BASEPATH . '/db.inc.php');

class WechatRun {

    const TIME_LENGTH = 600;

    private $weObj;
    private $config;
    private $user = array();  //包括fakeid, state, time

    public function __construct(&$weObj, &$config) {
        $this->weObj = $weObj;
        $this->config = $config;
        
        $fakeid = $weObj->getRevFrom();
        $ctime = time();
        
        $uid = md5($fakeid);
        session_id($uid);
        session_start();
        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            if (!isset($user['time']) || $user['time'] + self::TIME_LENGTH < $ctime) {
                $user['state'] = false;
            }
        } else {
            $user['fakeid'] = $fakeid;
            $user['state'] = false;
        }
        $user['time'] = $ctime;
        $this->saveState();
    }

    public function onText() {
        $content = $this->weObj->getRevContent();
        switch ($content) {
            case '下一页':
                $this->toNextPage();
                break;
            
            case '签到':
                $this->toSignIn();
                break;
            
            default :
                $voteObj = new WechatVote($this->weObj);
                if ($voteObj->doVote()) {
                    $this->user['state'] = 'WechatVote';
                    $this->saveState();
                } else {
                    $this->weObj->text("hello, I'm wechat")->reply();
                }
                break;
        }
        exit;
    }

    public function onLocation() {
        $location = $this->weObj->getRevGeo();
        $dpObj = new Dianping($this->weObj, $this->config['dianping'], $location['x'], $location['y']);
        if ($dpObj->doDianping()) {
           
            $user['state'] = 'Dianping';
            $user['Dianping'] = array(
                'x' => $location['x'],
                'y' => $location['y'],
                'page' => 1,
            );
            $this->saveState();

            exit;
        }
    }

    public function onEvent() {
        $event = $this->weObj->getRevEvent();
        switch ($event['event']) {
            case 'subscribe':
                break;

            case 'unsubscribe':
                break;

            case 'LOCATION':
                $this->toEventLocation();
                break;

            default:
                break;
        }
        exit;
    }

    private function saveState() {
        $_SESSION['user'] = serliaze($this->user);
    }

    private function toNextPage() {
        if ($this->user && $this->user['state'] == 'Dianping') {
            $data = $this->user['Dianping'];
            $dpObj = new Dianping($this->weObj, $this->config['dianping'], $data['x'], $data['y'], $data['page'] + 1);
            if ($dpObj->doDianping()) {
                $this->user['Dianping']['page'] ++;
                $this->saveState();
            }
        }
    }
    
    private function toSignIn() {
        if(isset($this->user['location'])) {
            $location = $this->user['location'];
            $location['status'] = 0;
            
            $db = DB::connect();
            unset($location['precision']);
            if(!$db->user_location()->insert($location)) {
                $content = 'database error';
            } else if(!$location['status']) {
                $content = '不在签到范围内，签到失败';
            } else {
                $content = '签到成功';
            }
        } else {
            $content = '获取位置信息失败，请退出重试';
        }
        $this->weObj->text($content)->reply();
        $this->user['state'] = 'SignIn';
        $this->saveState();
    }
    
    private function toSubscribe() {
        
    }

    private function toUnsubscribe() {
        
    }

    private function toEventLocation() {
        $location = $this->weObj->getRevEventGeo();
        $location['fakeid'] = $this->user['fakeid'];
        $location['time'] = $this->user['time'];
        $this->user['location'] = $location;
        $this->saveState();
        return $location;
    }

}
