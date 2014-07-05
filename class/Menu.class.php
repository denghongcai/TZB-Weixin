<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends TZB_Base {
    static private $str = array(
        'TZB_GUIDE' => "TZB_GUIDE",
        'TZB_MEETING' => "TZB_MEETING",
        'TZB_CONNECT' => "TZB_CONNECT",
        
    );
    
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
            default :
                $this->returnData['type'] = 'text';
                $this->returnData['data'] = 'default';
                break;
        }
        
        return $this->returnData;
    }
    
    protected function showError($error) {
        ;
    }
}

