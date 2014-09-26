<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('comment_model');
    }
    
    public function index($page = 1) {
        $data['comments'] = $this->comment_model->getComment($page);
        $data['total_counts'] = $this->comment_model->getTotalCounts(FALSE);
        $data['curr_page'] = $page;
        $data['limit'] = 5;
        $data['total_pages'] = $this->comment_model->getTotalPages();
        $this->load->view('comment/display', $data);
    }
    
    public function post() {
        $this->load->view('comment/post');
    }
    
    public function doPost() {
        $data['Name'] = $this->input->post('name');
        $data['Content'] = $this->input->post('comment');
        if($data['Name']) {
            $data['Name'] = htmlspecialchars($data['Name']);
        } else {
            $data['Name'] = "";
        }
        if($data['Content']) {
            $data['Content'] = htmlspecialchars($data['Content']);
            $data['Content'] = nl2br($data['Content']);
        } else {
            $data['Content'] = "";
        }
        //$data['Time'] = time();
        $this->comment_model->addComment($data);
        redirect('comment/success');
    }
    
    public function success() {
        $this->load->view('comment/success');
    }
}