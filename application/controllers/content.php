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
        $data = $this->content_model->GetContentByCategory($this->input->get('categoryid', TRUE));
        foreach($data as &$row){
            if(isset($row['CONTENTID'])){
                $cid = $row['CONTENTID'];
                unset($row['CONTENTID']);
                $row['DT_RowId'] = 'row_'.$cid;
            }
        }
        echo json_encode(
            array(
                'data'=>$data
            )
        );
    }

    public function UpdateContent()
    {
        $action = $this->input->get('action', TRUE);
        if($action == FALSE)
            $action = $this->input->post('action', TRUE);
        switch($action)
        {
            case 'Add':
                $data = $this->input->post(NULL, FALSE);
                $data['Content'] = base64_decode($data['Content']);
                array_map("trim", $data);
                $this->content_model->ReplaceContent($data);
                $this->session->set_flashdata(
                    array(
                        'error'=>0
                    )
                );
                redirect(base_url('content/UpdateContent'));
                break;
            case 'edit':
                $data = $this->input->post('data', FALSE);
                array_map("trim", $data);
                $data['CONTENTID'] = substr($this->input->post('id', TRUE), 4);
                $this->content_model->ReplaceContent($data);
                $data = $this->content_model->GetContentByID($data['CONTENTID']);
                $data['DT_RowId'] = 'row_'.$data['CONTENTID'];
                unset($data['CONTENTID']);
                $jsondata = array();
                $jsondata['row'] = $data;
                //echo json_encode($jsondata);
                break;
            case 'remove':
                $data = $this->input->post('id', TRUE);
                foreach($data as $row){
                    $this->content_model->DeleteContent(substr($row,4));
                }
                $data = array();
                echo json_encode($data);
                break;
            default:
                $this->load->view('includes/header');
                $data = array();
                $data['error'] = $this->session->flashdata('error');
                $data['category'] = $this->content_model->GetCategory();
                $this->load->view('adminUpdateContent', $data);
                $this->load->view('includes/footer');
        }
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
