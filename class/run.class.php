<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
        $this->user = $user;
        $this->saveState();
    }

    public function onText() {
        $content = $this->weObj->getRevContent();
        switch ($content) {
//            case '下一页':
//                if($this->toNextPage()) {
//                    exit;
//                }
//                break;
            
//            case '签到':
//                $this->toSignIn();
//                exit;
            
            default :
                $voteObj = new WechatVote($this->weObj);
                if ($voteObj->doVote()) {
                    $this->user['state'] = 'WechatVote';
                    $this->saveState();
                    exit;
                } 
                break;
        }
        //$this->weObj->text("hello, I'm wechat")->reply();
        $this->user['state'] = false;
        $this->saveState();
        exit;
    }

    public function onLocation() {
        $location = $this->weObj->getRevGeo();
        $dpObj = new Dianping($this->weObj, $this->config['dianping'], $location['x'], $location['y']);
        if ($dpObj->doDianping()) {
           
            $this->user['state'] = 'Dianping';
            $this->user['Dianping'] = array(
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
                $this->toSubscribe();
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
        $_SESSION['user'] = serialize($this->user);
    }

    private function toNextPage() {
        if ($this->user && $this->user['state'] == 'Dianping') {
            $data = $this->user['Dianping'];
            $dpObj = new Dianping($this->weObj, $this->config['dianping'], $data['x'], $data['y'], $data['page'] + 1);
            if ($dpObj->doDianping()) {
                $this->user['Dianping']['page'] ++;
                $this->saveState();
            }
            return true;
        } else {
            return false;
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
        $content = "您好，感谢关注“创青春”全国大学生创业大赛官方微信。2014年大赛由共青团中央、教育部、人力资源和社会保障部、中国科协、全国学联、湖北省人民政府主办，华中科技大学、共青团湖北省委、武汉东湖新技术开发区承办。
中国梦 创业梦 我的梦！
创新 创意 创造 创业 创青春！
我们将为您全方位推送新闻动态、赛事通知、会务指南等精彩内容，并陆续推出“有问必答”、 “注册”、“赛事直通车”等个性化服务，敬请关注。如有任何疑问，欢迎给我们留言，我们将尽快回复您。
（ps：提问超过时限小编就没办法回复给您了mo-委屈，小编不是故意的哦~有时候太忙就mo-晕所以如果可以的话您有很重要的问题如果没有及时收到回复烦请您再发一遍，一定会回得哦~谢谢啦~）\n现在回复“吉祥物”可以选出你喜欢的大赛吉祥物啦～";
        
        $this->weObj->text($content)->reply();
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
