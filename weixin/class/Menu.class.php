<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends TZB_Base {
    private $keyword;
    
    public function __construct($key) {
        $this->keyword = $key;
        $this->returnData['state']['keyword'] = $key;
    }
    
    public function getReturn() {
        switch ($this->keyword) {
            case 'TZB_GUIDE':
            case 'TZB_MEETING':
            case 'TZB_ACTIVITY':
            case 'TZB_POLICY':
            case 'TZB_PERSON':
            case 'TZB_TEAM':
            case 'TZB_PIC':
            case 'TZB_CONNECT':
                $content = new Content($this->keyword);
                $this->returnData['type'] = 'text';
                $this->returnData = $content->getReturn();
                break;
            case 'TZB_WEATHER':
                $weather = new Weather();
                $this->returnData = $weather->getReturn();
                break;
            case 'TZB_AMUSE':
                $this->returnData['type'] = 'text';
                $this->returnData['data'] = '发送当前位置信息即可查看周边商铺';
                $this->returnData['state']['keyword'] = 'Dianping';
                break;
            case 'TZB_MAP':
                $this->returnData['type'] = 'text';
                $this->returnData['data'] = '请发送【出发地】的位置信息';
                $this->returnData['state']['keyword'] = 'Map';
                $this->returnData['state']['data'] = array(
                    'fromcoord' => '',
                    'from' => '',
                    'to' => '',
                    'tocoord' => '',
                    'policy' => '1',
                    'referer' => '',
                );
                break;
            default :
				return false;
                //$this->returnData['type'] = 'text';
               // $this->returnData['data'] = $this->keyword;
                break;
        }
        
        return $this->returnData;
    }
    
}

