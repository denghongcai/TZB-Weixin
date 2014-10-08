<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends TZB_Base {
    private $keyword;
    
    public function __construct($key) {
        $this->keyword = $key;
        $this->returnData['state']['keyword'] = $key;
    }
    
    public function getReturn($page = 1) {
        switch ($this->keyword) {
            case 'TZB_GUIDE':
            case 'TZB_MEETING':
            case 'TZB_ACTIVITY':
            case 'TZB_POLICY':
            case 'TZB_PERSON':
            case 'TZB_TEAM':
            case 'TZB_PIC':
            case 'TZB_CONNECT':
            case 'TZB_ZN':
            case 'TZB_TZ':
                $content = new Content($this->keyword, $page);
                $this->returnData['type'] = 'text';
                $this->returnData = $content->getReturn();
                break;
            case 'TZB_WEATHER':
                $weather = new Weather();
                $this->returnData = $weather->getReturn();
                break;
            case 'TZB_AMUSE':
                break;
                $this->returnData['type'] = 'text';
                $this->returnData['data'] = '发送当前位置信息即可查看周边商铺';
                $this->returnData['state']['keyword'] = 'Dianping';
                break;
            case 'TZB_MAP':
                $content = new Content($this->keyword, $page);
                $this->returnData = $content->getReturn();
                $this->returnData['state']['keyword'] = 'Map';
                if($this->returnData['type'] == 'news') {
                    $item = array(
                        'Title' => '如须使用地图导航，请发送【出发地】的位置信息（如何发送位置信息？点击查看帮助~）',
                        'Url' => 'http://tzb-weixin.dhc.house/content.php?id=37',
                    );
                    array_push($this->returnData['data'], $item);
                } else if($this->returnData['type'] == 'text'){
                    $this->returnData['data'] .= "\n如须使用地图导航，请发送【出发地】的位置信息";
                }
                $location = array(
                    'fromcoord' => '',
                    'from' => '',
                    'to' => '',
                    'tocoord' => '',
                    'policy' => '1',
                    'referer' => '',
                );
                $this->returnData['state']['data'] = array_merge($this->returnData['state']['data'], $location);
                
                break;
            default :
                //$this->returnData['type'] = 'text';
               // $this->returnData['data'] = $this->keyword;
                break;
        }
        
        return $this->returnData;
    }
    
}

