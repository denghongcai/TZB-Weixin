<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KNOWLEDGE extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('knowledge_model');
    }

    public function KnowledgeList()
    {
        $this->load->view('includes/header');
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

    public function UpdateKnowledge()
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
                $data['Tag'] = explode(',',$data['Tag']);
                $this->knowledge_model->ReplaceKnowledge($data);
                $this->session->set_flashdata(
                    array(
                        'error'=>0
                    )
                );
                redirect(base_url('knowledge/UpdateKnowledge'));
                break;
            case 'edit':
                $kid = $this->input->post('id', TRUE);
                $data = $this->input->post('data', TRUE);
                array_map('trim', $data);
                $data['KNOWID'] = substr($kid, 4);
                $data['Tag'] = explode(',',$data['Tag']);
                $this->knowledge_model->ReplaceKnowledge($data);
                break;
            case 'remove':
                $kid = $this->input->post('id', TRUE);
                foreach($kid as $row){
                    $this->knowledge_model->DeleteKnowledge(substr($row, 4));
                }
                $jsondata = array();
                echo json_encode($jsondata);
                break;
            default:
                $this->load->view('includes/header');
                $data = array();
                $data['error'] = $this->session->flashdata('error');
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