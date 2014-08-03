<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Knowledge_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function GetKnowledgeList($limit = NULL, $offset = 0)
    {
        $data = array();
        $kquery = $this->db->get('Knowledge', $limit, $offset);
        foreach($kquery->result_array() as $krow){
            $tag = array();
            $taquery = $this->db->get_where('TagAssocKnow',
                array(
                    'KNOWID'=>$krow['KNOWID']
                )
            );
            foreach($taquery->result_array()as $trow){
                $tquery = $this->db->get_where('Tag',
                    array(
                        'TAGID'=>$trow['TAGID']
                    )
                );
                $tresult = $tquery->row_array();
                array_push($tag, $tresult['TagName']);
            }
            $krow['Tag'] = $tag;
            array_push($data, $krow);
        }
        return $data;
    }

    function GetKnowledgeByID($kid)
    {
        $kquery = $this->db->get_where('Knowledge',
            array(
                'KNOWID'=>$kid
            )
        );
        $krow = $kquery->row_array();
        $tag = array();
        $taquery = $this->db->get_where('TagAssocKnow',
            array(
                'KNOWID'=>$krow['KNOWID']
            )
        );
        foreach($taquery->result_array()as $trow){
            $tquery = $this->db->get_where('Tag',
                array(
                    'TAGID'=>$trow['TAGID']
                )
            );
            $tresult = $tquery->row_array();
            array_push($tag, $tresult['TagName']);
        }
        $krow['Tag'] = $tag;
        return $krow;
    }

    function ReplaceKnowledge($data)
    {
        $kdata = array();
        $kdata['KNOWID'] = $data['KNOWID'];
        $kdata['Question'] = $data['Question'];
        $kdata['Answer'] = $data['Answer'];
        $this->db->replace('Knowledge', $kdata);
        $knowid =  $this->db->insert_id();
        $tdata = $data['Tag'];
        $tiddata = array();
        foreach($tdata as $row){
            $query = $this->db->get_where('Tag', array('TagName'=>$row));
            if($query->num_rows() == 0){
                $this->db->insert('Tag',
                    array(
                        'TagName'=>$row
                    )
                );
                array_push($tiddata, $this->db->insert_id());
            }
            else {
                $query = $query->row_array();
                array_push($tiddata, $query['TAGID']);
            }
        }
        $this->db->delete('TagAssocKnow',
            array(
                'KNOWID'=>$knowid
            )
        );
        foreach($tiddata as $row){
            $this->db->insert('TagAssocKnow',
                array(
                    'KNOWID'=>$knowid,
                    'TAGID'=>$row
                )
            );
        }
        return TRUE;
    }

    function DeleteKnowledge($knowid)
    {
        $this->db->delete('Knowledge',
            array(
                'KNOWID'=>$knowid
            )
        );
        $this->db->delete('TagAssocKnow',
            array(
                'KNOWID'=>$knowid
            )
        );
        return TRUE;
    }

    function GetTag($tagname = NULL)
    {
        if(!$tagname){
            $query = $this->db->get('Tag');
        }
        else {
            $this->db->like('TagName', $tagname);
            $query = $this->db->get('Tag');
        }
        return $query->result_array();
    }

}