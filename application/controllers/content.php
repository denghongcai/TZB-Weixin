<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('content_model');
    }

    public function ContentList()
    {
        $data = array();
        $category = $this->content_model->GetCategory();
        $data['category'] = $category;
        $this->load->view('includes/header');
        $this->load->view('adminContentList', $data);
        $this->load->view('includes/footer');
    }

    public function ContentListAjax()
    {
        $data = $this->content_model->GetContent($this->input->get('categoryid', TRUE));
        echo json_encode(
            array(
                'data'=>$data
            )
        );
    }

    public function UpdateContent()
    {
        $action = $this->input->get('action', TRUE);
        $this->load->view('includes/header');
        switch($action)
        {
            case 'Add':
                $data = $this->input->post(NULL, TRUE);
                array_map("trim", $data);
                $this->content_model->ReplaceContent($data);
                $this->session->set_flashdata(
                    array(
                        'error'=>0
                    )
                );
                redirect(base_url('content/UpdateContent'));
                break;
            default:
                $data = array();
                $data['error'] = $this->session->flashdata('error');
                $data['category'] = $this->content_model->GetCategory();
                $this->load->view('adminUpdateContent', $data);
        }
        $this->load->view('includes/footer');
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
