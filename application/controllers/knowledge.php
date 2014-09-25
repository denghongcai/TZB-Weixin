<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KNOWLEDGE extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('knowledge_model');
    }

    public function KnowledgeList()
    {
        $this->load->view('includes/header', array('act'=>'knowledge'));
		$this->load->view('adminKnowledgeList');
        $this->load->view('includes/footer');
    }

    // 不使用服务器过滤
    public function KnowledgeListAjax()
    {
        $data = $this->knowledge_model->GetKnowledgeList(
            //$this->input->get('length', TRUE),
            //$this->input->get('start', TRUE)
        );
        array_walk($data, array($this, 'ImplodeTag'));
        foreach($data as &$row){
            if(isset($row['KNOWID'])){
                $kid = $row['KNOWID'];
                unset($row['KNOWID']);
                $row['Edit'] = '<a href="'.base_url('knowledge/UpdateKnowledge/'.$kid).'">编辑</a>';
                $row['Remove'] = '<a href="'.base_url('knowledge/UpdateKnowledge?action=remove&id='.$kid).'">删除</a>';
                $row['DT_RowId'] = 'row_'.$kid;
            }
        }
        echo json_encode(
            array(
                'data'=>$data
            )
        );
    }

    private function ImplodeTag(&$value)
    {
        $value['Tag'] = implode(', ', $value['Tag']);
    }

    public function UpdateKnowledge($kid = null)
    {
        $action = $this->input->get('action', TRUE);
        if($action == FALSE){
            $action = $this->input->post('action', TRUE);
        }
        switch($action)
        {
            case 'Add':
                $data = $this->input->post(NULL, TRUE);
                array_map('trim', $data);
                //合并tag
				$tag_js = explode(',',$data['Tag']);
				$tag_input = explode(',',$data['Tags']);
				$tag = array_merge($tag_js, $tag_input);
				$tag = array_filter($tag);
				$tag = array_map('trim', $tag);
				$data['Tag'] = array_unique($tag);
				unset($data['Tags']);
				
                $this->knowledge_model->ReplaceKnowledge($data);
                $this->session->set_flashdata(
                    array(
                        'error'=>0
                    )
                );
                redirect(base_url('knowledge/UpdateKnowledge'));
                break;
            case 'edit':
                $kid = $this->input->get('id', TRUE);
                $data = $this->input->post(NULL, TRUE);
                array_map('trim', $data);
                $data['KNOWID'] = $kid;var_dump($data);
				//合并tag
				$tag_js = explode(',',$data['Tag']);
				$tag_input = explode(',',$data['Tags']);
				$tag = array_merge($tag_js, $tag_input);
				$tag = array_filter($tag);
				$tag = array_map('trim', $tag);
				$data['Tag'] = array_unique($tag);
				unset($data['Tags']);
				
                $this->knowledge_model->ReplaceKnowledge($data);
                $this->session->set_flashdata(
                    array(
                        'error'=>0
                    )
                );
                redirect(base_url('knowledge/UpdateKnowledge'));
                break;
            case 'remove':
                $kid = $this->input->get('id', TRUE);
                $this->knowledge_model->DeleteKnowledge($kid);
                redirect('knowledge/KnowledgeList');
                break;
            default:
                $this->load->view('includes/header', array('act'=>'knowledge'));
                $data = array();
                $data['error'] = $this->session->flashdata('error');
                if($kid != null){
                    $data['data'] = $this->knowledge_model->GetKnowledgeByID($kid);
                    $data['data']['Tag'] = implode(', ', $data['data']['Tag']);
                    $data['action'] = base_url('knowledge/UpdateKnowledge?action=edit&id='.$kid);
                }
                else{
                    $data['data'] = array();
                    $data['data']['Question'] = "";
                    $data['data']['Answer'] = "";
                    $data['data']['Tag'] = "";
                    $data['action'] = base_url('knowledge/UpdateKnowledge?action=Add');
                }
                $this->load->view('adminUpdateKnowledge', $data);
                $this->load->view('includes/footer');
        }
    }

    public function GetTagAjax()
    {
        $TagName = $this->input->post('TagName', TRUE);
        $data = $this->knowledge_model->GetTag($TagName);
        $jsondata = array();
        foreach($data as $row) {
            array_push($jsondata, $row['TagName']);
        }
        echo json_encode($jsondata);
    }
}

/* End of file knowledge.php */
/* Location: ./application/controllers/knowledge.php */