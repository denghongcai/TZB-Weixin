<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function CheckLogin()
    {
        if ( $this->session->userdata('LoggedIn') != TRUE ){
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function LoginAction($userInfo)
    {
        $userInfo['PassWord'] = sha1($userInfo['PassWord']);
       // var_dump($userInfo);
        $query = $this->db->get_where('User', $userInfo);
        if ( $query->num_rows() !== 1 ){
           return FALSE;
        }
        else {
           $userInfo = $query->row_array();
           $this->session->set_userdata(
               array(
                   'UID' => $userInfo['UID'],
                   'UserName' => $userInfo['UserName'],
                   'LoggedIn' => TRUE
               )
           );
           return TRUE;
        }
    }

    function LogoutAction()
    {
        $this->session->unset_userdata(
            array(
                'UserName' => '',
                'LoggedIn' => ''
            )
        );
        return TRUE;
    }

    function ModifyPassword($data)
    {
        //TODO:执行结果检测
        $this->db->update('User',
            array(
                'PassWord'=>$data['PassWord']
            ),
            array(
                'UID'=>$data['UID']
            )
        );
        return TRUE;
    }

    function AddUser($data)
    {
        $data['PassWord'] = sha1($data['PassWord']);
        $this->db->insert('User', $data);
        if($this->db->affected_rows() == 1) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
}
