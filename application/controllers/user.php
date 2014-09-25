<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class USER extends MY_Controller {

    public function ModifyPassword()
    {
        $data = $this->input->post(NULL, TRUE);
        if($data === FALSE){
            $data = array();
            $data['error'] = $this->session->flashdata('error');
            $this->load->view('includes/header', array('act'=>'user'));
            $this->load->view('adminModifyPassword', $data);
            $this->load->view('includes/footer');
        }
        else {
            $info = array();
            if($data['curPassword'] != $data['newPassword']){
                $this->session->set_flashdata(
                    array(
                        'error'=>1
                    )
                );
                redirect(base_url('user/ModifyPassword'));
            }
            else {
                $info['UID'] = $this->session->userdata('UID');
                $info['PassWord'] = $data['newPassword'];
                $this->user_model->ModifyPassword($info);
                $this->session->set_flashdata(
                    array(
                        'error'=>0
                    )
                );
                redirect(base_url('user/ModifyPassword'));
            }
        }
    }

    public function ManageUser()
    {
        $action = $this->input->get('action', TRUE);
        switch($action)
        {
            case 'Add':
                if($this->user_model->AddUser($this->input->post(NULL, TRUE))){
                    redirect(base_url('user/ManageUser'));
                }
                else {
                    redirect(base_url('user/ManageUser'));
                }
                break;
            default:
                $this->load->view('includes/header', array('act'=>'user'));
                $this->load->view('adminManageUser');
                $this->load->view('includes/footer');
        }
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */