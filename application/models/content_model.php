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

    function GetContent($categoryid = NULL)
    {
        $data = array();
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

    function ReplaceContent($data)
    {
        $cdata = array();
        $cdata['Title'] = $data['Title'];
        $cdata['Author'] = $data['Author'];
        $cdata['Content'] = $data['Content'];
        $this->db->replace('Content', $cdata);
        $contentid =  $this->db->insert_id();
        $cadata = $data['Category'];
        $query = $this->db->insert('CategoryAssocContent',
            array(
                'CATEGORYID'=>$cadata,
                'CONTENTID'=>$contentid
            )
        );
        return TRUE;
    }
}