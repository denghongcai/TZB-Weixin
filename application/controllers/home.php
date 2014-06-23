<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HOME extends MY_Controller {

	public function index()
	{
        $this->load->view('includes/header');
		$this->load->view('adminHome');
        $this->load->view('includes/footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */