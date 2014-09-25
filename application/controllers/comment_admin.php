<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comment_admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('comment_model');
    }

    public function CommentList() {
        $this->load->view('includes/header');
        $this->load->view('adminCommentList');
        $this->load->view('includes/footer');
    }

    public function CommentListAjax() {
        $data = $this->comment_model->getComment(-1, 0);
        foreach ($data as &$row) {
            if (isset($row['COMMENTID'])) {
                $cid = $row['COMMENTID'];
                unset($row['COMMENTID']);
                $is_show = $row['is_show'] ? "取消展示" : "展示";
                $row['Edit'] = '<a href="' . base_url('comment_admin/show/' . $cid) . '">' . $is_show . '</a>';
                $row['Remove'] = '<a href="' . base_url('comment_admin/delete/' . $cid) . '">删除</a>';
                $row['DT_RowId'] = 'row_' . $cid;
                $row['Content'] = $row['Content'];
                $row['Name'] = $row['Name'];
            }
        }
        echo json_encode(
                array(
                    'data' => $data
                )
        );
    }
    
    public function show($id) {
        $this->comment_model->setShow($id);
        redirect('comment_admin/CommentList');
    }
    
    public function delete($id) {
        $this->comment_model->deleteComment($id);
        redirect('comment_admin/CommentList');
    }

}
