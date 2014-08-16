<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Know extends TZB_Base {

    private $keyword;
    private $db;

    public function __construct($keyword) {
        $this->keyword = $keyword;
        $this->returnData['type'] = 'text';
        $this->returnData['state']['keyword'] = 'Know';
        $this->returnData['state']['data'] = $keyword;
        $this->db = DB::connect();
    }

    public function getReturn() {
        $data = $this->getAnswer();
        $content = '';
        $i = 1;
        foreach($data as $row) {
            $content .= "Q$i:【$row[Question]】\nA$i: $row[Answer]\n";
            $i++;
        }
        $this->returnData['data'] = $content;
        return $this->returnData;
    }

    private function getAnswer() {
        $tags = $this->db->Tag()->where('TagName LIKE ?', '%' . $this->keyword . '%');

        $data = array();
        foreach ($tags as $tag) {
            $TagAssocKnow = $this->db->TagAssocKnow()->where('TAGID', $tag['TAGID']);
            foreach ($TagAssocKnow as $row) {
                $data[] = $this->db->Knowledge()->where('KNOWID', $row['KNOWID'])->limit(1)->fetch();
            }
        }
        if(!empty($data)) {
            return $data;
        }
        //全文搜索
        $Knowledge = $this->db->Knowledge()->where('Question LIKE ?', '%' . $this->keyword . '%')->or('Answer LIKE ?', '%' . $this->keyword . '%');
        foreach ($Knowledge as $row) {
                $data[] = $row;
        }
        return $data;
    }
    
}
