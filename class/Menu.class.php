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
        $this->returnData['state'] = $key;
    }
    
    public function getReturn() {
        switch ($this->keyword) {
            case 'TZB_GUIDE':
                $this->returnData['type'] = 'text';
                $this->returnData['data'] = self::$str['TZB_GUIDE'];
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

