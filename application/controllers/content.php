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
                $row['Edit'] = '<a href="'.base_url('content/UpdateContent/'.$cid).'">编辑</a>';
                $row['Remove'] = '<a href="'.base_url('content/UpdateContent?action=remove&id='.$cid).'">删除</a>';
                $row['DT_RowId'] = 'row_'.$cid;
            }
            $row['Content'] = mb_substr(strip_tags($row['Content']), 0, 80, 'UTF-8') . '…';
            $row['Title'] = "<a href='http://tzb-weixin.dhc.house/content.php?id=$row[CONTENTID]'>$row[Title]</a>";
        }
        echo json_encode(
            array(
                'data'=>$data
            )
        );
    }

    public function UpdateContent($id = null)
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
                $data = $this->input->post(NULL, FALSE);
                array_map("trim", $data);
                $data['CONTENTID'] = $this->input->get('id', TRUE);
                $data['Content'] = base64_decode($data['Content']);
                unset($data['Category']);
                $this->content_model->ReplaceContent($data);
                $data = $this->content_model->GetContentByID($data['CONTENTID']);
                $this->session->set_flashdata(
                    array(
                        'error'=>0
                    )
                );
                redirect(base_url('content/UpdateContent'));
                //echo json_encode($jsondata);
                break;
            case 'remove':
                $data = $this->input->get('id', TRUE);
                $this->content_model->DeleteContent($data);
                redirect(base_url('content/ContentList'));
                break;
            default:
                $this->load->view('includes/header');
                $data = array();
                $data['error'] = $this->session->flashdata('error');
                $data['category'] = $this->content_model->GetCategory();
                if($id != null){
                    $data['data'] = $this->content_model->GetContentByID($id);
                    $data['action'] = base_url('content/UpdateContent?action=edit&id='.$id);
                }
                else{
                    $data['data'] = array();
                    $data['data']['Title'] = "";
                    $data['data']['Author'] = "";
                    $data['data']['Content'] = "";
                    $data['action'] = base_url('content/UpdateContent?action=Add');
                }
                $this->load->view('adminUpdateContent', $data);
                $this->load->view('includes/footer');
        }
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
