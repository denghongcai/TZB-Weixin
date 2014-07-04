<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function GetTotalUniqueVisitor()
    {
        $this->db->distinct('VisitFakeID');
        $query = $this->db->get('Stat');
        return $query->result_array();
    }
}