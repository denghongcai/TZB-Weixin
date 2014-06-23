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

    function ReplaceKnowledge($data)
    {
        $kdata = array();
        $kdata['KNOWID'] = $data['KNOWID'];
        $kdata['Question'] = $data['Question'];
        $kdata['Answer'] = $data['Answer'];
        $this->db->replace('Knowledge', $kdata);
        $knowid =  $this->db->insert_id();
        $tdata = $data['Tag'];
        foreach($tdata as $row){
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

    function AddTag($tagname)
    {
        $this->db->insert('Tag',
            array(
                'TagName'=>$tagname
            )
        );
        return $this->db->insert_id();
    }

    function DeleteTag($tagid)
    {
        $this->db->delete('Tag',
            array(
                'TAGID'=>$tagid
            )
        );
        $this->db->delete('TagAssocKnow',
            array(
                'TAGID'=>$tagid
            )
        );
        return TRUE;
    }
}