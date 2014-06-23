<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dhc
 * Date: 14-6-21
 * Time: 上午10:56
 * To change this template use File | Settings | File Templates.
 */
class MY_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');

        if (!$this->user_model->checkLogin()){
            redirect(base_url('login'));
        }
    }
}