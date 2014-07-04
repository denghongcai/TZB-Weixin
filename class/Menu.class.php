<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends TZB_Base {
    private $keyword;
    
    public function __construct($key) {
        $this->keyword = $key;
        $this->returnData['state'] = $key;
    }
    
    public function getReturn() {
        switch ($this->keyword) {
            case 'TZB_GUIDE':
                $this->returnData['type'] = 'text';
                $this->returnData['data'] = 'aa';
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

