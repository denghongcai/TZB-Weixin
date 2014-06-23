<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LOGOUT extends CI_Controller {

	public function index()
	{
		$this->user_model->LogoutAction();
        redirect(base_url('login'));
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */