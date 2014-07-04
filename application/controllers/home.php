<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HOME extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('state_model');
    }

	public function index()
	{
        $uniqueVistorTotal = $this->state_model->GetTotalUniqueVisitor();
        $uniqueVistorTotalNum = count($uniqueVistorTotal);
        $data = array();
        $data['uvTotal'] = $uniqueVistorTotalNum;
        $this->load->view('includes/header');
		$this->load->view('adminHome', $data);
        $this->load->view('includes/footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */