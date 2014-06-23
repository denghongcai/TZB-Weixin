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
                'draw'=>$this->input->get('draw'),
                'recordsTotal'=>100,
                'recordsFiltered'=>100,
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
        $this->load->view('includes/header');
        $this->load->view('adminUpdateKnowledge');
        $this->load->view('includes/footer');
    }
}

/* End of file knowledge.php */
/* Location: ./application/controllers/knowledge.php */