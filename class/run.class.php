<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class WechatRun {

    const TIME_LENGTH = 3600;

    private $weObj;
    private $config;
    private $user = array(
        'fakeid' => '',
        'time' => 0,
        'state' => array(
            'keyword' => '',
            'data' => array()
        ),
    ); 
    private $returnData = array(
        'type' => false,
        'data' => null,
        'error' => 0,
        'state' => array(
            'keyword' => '',
            'data' => array(),
        )
    );

    public function __construct(&$weObj, &$config) {
        $this->weObj = $weObj;
        $this->config = $config;
        
        $fakeid = $weObj->getRevFrom();
        //$ctime = $weObj->getRevCtime();
        $ctime = time();
        session_id(md5($fakeid));
        session_start();
        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            if (!isset($user['time']) || $user['time'] + self::TIME_LENGTH < $ctime ||$user['fakeid'] != $fakeid) {
                $user['state'] = false;
            }
        } else {
            $user['fakeid'] = $fakeid;
            $user['state'] = false;
        }
        $user['time'] = $ctime;
        $this->user = $user;

    }
    
    public function __destruct() {
        if(!empty($this->returnData['type'])) {
            $type = $this->returnData['type'];
            $this->weObj->$type($this->returnData['data'])->reply();
        }
        $this->user['state'] = $this->returnData['state'];
        $this->saveState();
    }
    
    public function onText() {
        $content = $this->weObj->getRevContent();
        switch ($content) {
            case '下一页':
                $this->toNextPage();
                break;
            
            default :
                /*$this->returnData['type'] = 'text';
                $this->returnData['data'] = 'hello world';
                $this->user['state']['keyword'] = 'text';*/
                $menu = new Menu($content);
                $this->returnData = $menu->getReturn();
                if(empty($this->returnData['data'])) {
                    $know = new Know($content);
                    $this->returnData = $know->getReturn();
                }
                break;
        }
        exit;
    }

    public function onLocation() {
        $location = $this->weObj->getRevGeo();
        if($this->user['state']['keyword'] == 'Map') {
            $map = new Map($this->user['state']['data'], $location);
            $this->returnData = $map->getReturn();
            if(!$this->returnData['state']['keyword']) {
                $this->returnData['state']['keyword'] = 'Map';
                $this->returnData['state']['data'] = $this->user['state']['data'];
            }
        } else {
            //$this->toDianping($location);
        }
    }

    public function onEvent() {
        $event = $this->weObj->getRevEvent();
        switch ($event['event']) {
            case 'subscribe':
                $this->toSubscribe();
                break;

            case 'unsubscribe':
                break;
            
            case 'CLICK':
                $menu = new Menu($event['key']);
                $this->returnData = $menu->getReturn();
                break;

            default:
                break;
        }
    }

    private function saveState() {
        $_SESSION['user'] = serialize($this->user);
    }

    private function toNextPage() {
        switch ($this->user['state']['keyword']) {
            case 'Dianping': 
                $data = $this->user['state']['data'];
                $location = array(
                    'x' => $data['latitude'],
                    'y' => $data['longitude'],
                );
                $this->toDianping($location, $data['page'] + 1);
                break;
            case 'Map':
            case 'Content':
                $data = $this->user['state']['data'];
                $menu = new Menu($data['keyword']);
                $this->returnData = $menu->getReturn($data['page'] + 1);
                break;
            default:
                $this->returnData['type'] = 'text';
                $this->returnData['data'] = "请通过菜单选择想要的功能";
                break;
        }
    }
    
    
    private function toSubscribe() {
        $this->returnData['type'] = 'text';
        $this->returnData['data'] = '欢迎订阅创青春官方微信平台';
    }

    private function toUnsubscribe() {
        
    }
    
    private function toDianping($location, $page = 1) {
        $dpObj = new Dianping($this->config['dianping'], $location['x'], $location['y'], $page);
        $this->returnData = $dpObj->getReturn();
    }
}
