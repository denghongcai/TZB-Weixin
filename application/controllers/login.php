<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//当使用数据库作为Session存储容器时可能出现奇怪的Bug
class LOGIN extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

	public function index()
	{
        $data = $this->input->post(NULL, TRUE);
        if($data === FALSE){
            $data = array();
            $data['error'] = $this->session->flashdata('error');
		    $this->load->view('login', $data);
        }
        else {
            $loginInfo = array(
                'UserName'=>$data['UserName'],
                'PassWord'=>$data['PassWord']
            );
            if($this->user_model->LoginAction($loginInfo)){
                redirect(base_url('home'));
            }
            else {
                $this->session->set_flashdata(
                    array(
                        'error'=>TRUE
                    )
                );
                redirect(base_url('login'));
            }
        }
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */