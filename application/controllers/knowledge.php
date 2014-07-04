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
        $this->load->view('includes/header');
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
            default:
                $data = array();
                $data['error'] = $this->session->flashdata('error');
                $this->load->view('adminUpdateKnowledge', $data);
        }
        $this->load->view('includes/footer');
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