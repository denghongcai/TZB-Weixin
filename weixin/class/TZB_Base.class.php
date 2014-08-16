<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

abstract class TZB_Base {
    protected $returnData = array(
        'type' => false,
        'data' => array(),
        'error' => 0,
        'state' => array(
            'keyword' => false,
            'data' => array(),
        )
    );
    
    abstract public function getReturn() ;
}
