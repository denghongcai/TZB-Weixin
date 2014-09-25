<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment_Model extends CI_Model {
    
    const PAGECOUNT = 9;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getComment($page = 1, $is_show = 1) {
        $this->db->where('is_del', 0);
        if($is_show) {
            $this->db->where('is_show', 1);
        }
        if($page >= 1) {
            $this->db->limit(self::PAGECOUNT, ($page - 1) * self::PAGECOUNT);
        }
        
        $this->db->order_by('Time', 'desc');
        $query = $this->db->get('Comment');
        return $query->result_array();
    }
    
    public function getTotalPages($is_show = 1) {
        $this->db->where('is_del', 0);
        if($is_show) {
            $this->db->where('is_show', 1);
        }
        $query = $this->db->get('Comment');
        return ceil($query->num_rows() / self::PAGECOUNT);
    }
    
    public function getTotalCounts() {
        $query = $this->db->get_where('Comment', array('is_del' => 0));
        return $query->num_rows();
    }
    
    
    public function addComment($data) {
        $this->db->insert('Comment', $data);
        return $this->db->affected_rows();
    }
    
    public function setShow($id) {
        $query = $this->db->limit(1)->get_where('Comment', array('COMMENTID' => $id));
        $row = $query->row_array();
        if(empty($row)) {
            return false;
        }
        $row['is_show'] = $row['is_show'] ? '0' : '1';
        unset($row['COMMENTID']);
        $this->db->where('COMMENTID', $id);
        $this->db->update('Comment', $row);
        return $this->db->affected_rows();
    }
    
    public function deleteComment($id) {
        $query = $this->db->limit(1)->get_where('Comment', array('COMMENTID' => $id));
        $row = $query->row_array();
        if(empty($row)) {
            return false;
        }
        $row['is_del'] = "1";
        unset($row['COMMENTID']);
        $this->db->where('COMMENTID', $id);
        $this->db->update('Comment', $row);
        return $this->db->affected_rows();
    }
}