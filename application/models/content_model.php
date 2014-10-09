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
        $this->db->select('Content.*');
        $this->db->select('CategoryAssocContent.CATEGORYID');
        $this->db->limit(1);
        $this->db->join('CategoryAssocContent', 'CategoryAssocContent.CONTENTID=Content.CONTENTID');
        $query = $this->db->get_where('Content',
            array(
                'Content.CONTENTID'=>$contentid
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
        $cdata['Indexnum'] = $data['Indexnum'];
        $this->db->replace('Content', $cdata);
        if(isset($data['Category'])){
            $contentid =  $this->db->insert_id();
            $cadata['CATEGORYID'] = $data['Category'];
            $cadata['Indexnum'] = $data['Indexnum'];
            $query = $this->db->get_where('CategoryAssocContent', array('CONTENTID'=>$contentid));
            if($query->num_rows() > 0) {
                $this->db->where('CONTENTID', $contentid);
                $this->db->update('CategoryAssocContent', $cadata);
            } else {
                $cadata['CONTENTID'] = $contentid;
                $this->db->insert('CategoryAssocContent', $cadata);
            }
            
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
    
    //获取访问量
    function GetVisitor($contentid) {
        $query = $this->db->get_where('Visitor', array('ContentID'=>$contentid));
        return $query->num_rows();
    }
}
