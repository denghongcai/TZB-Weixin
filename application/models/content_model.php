<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function GetCategory()
    {
        $query = $this->db->get('ContentCategory');
        return $query->result_array();
    }

    function GetContentByCategory($categoryid = NULL)
    {
        $data = array();
        //$this->db->order_by('AddTime', 'desc');
        $query = $this->db->get_where('CategoryAssocContent',
            array(
                'CATEGORYID'=>$categoryid
            )
        );
        $cidresult = $query->result_array();
        foreach($cidresult as $row){
            $query = $this->db->get_where('Content',
                array(
                    'CONTENTID'=>$row['CONTENTID']
                )
            );
            array_push($data, $query->row_array());
        }
        return $data;
    }

    function GetContentByID($contentid = NULL)
    {
        $query = $this->db->get_where('Content',
            array(
                'CONTENTID'=>$contentid
            )
        );
        return $query->row_array();
    }

    function ReplaceContent($data)
    {
        $cdata = array();
        if(isset($data['CONTENTID'])){
            $cdata['CONTENTID'] = $data['CONTENTID'];
        }
        $cdata['Title'] = $data['Title'];
        $cdata['Author'] = $data['Author'];
        $cdata['Content'] = $data['Content'];
        $this->db->replace('Content', $cdata);
        if(isset($data['Category'])){
            $contentid =  $this->db->insert_id();
            $cadata = $data['Category'];
            $query = $this->db->insert('CategoryAssocContent',
                array(
                    'CATEGORYID'=>$cadata,
                    'CONTENTID'=>$contentid
                )
            );
        }
        return TRUE;
    }

    function DeleteContent($contentid)
    {
        $this->db->delete('Content',
            array(
                'CONTENTID'=>$contentid
            )
        );
        $this->db->delete('CategoryAssocContent',
            array(
                'CONTENTID'=>$contentid
            )
        );
        return TRUE;
    }
}
