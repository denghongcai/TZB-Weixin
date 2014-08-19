<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends TZB_Base {
    const PAGECOUNT = 5;
    const ERROR_PAGE = 'ERROR_PAGE';
    const EEEOR_KEYWORD = 'EEEOR_KEYWORD';
    
    private $db;
    
    public function __construct($keyword, $page = 1) {
        $this->db = DB::connect();
        $this->returnData['state']['keyword'] = 'Content';
        $this->returnData['state']['data'] = array(
            'keyword' => $keyword,
            'page'  => $page,
        );
    }
    
    public function getReturn() {
        $error = $this->getContent();
        if($error !== true) {
            $this->showError($error);
        }
        return $this->returnData;
    }
    
    protected function showError($error) {
        switch ($error) {
            case self::ERROR_PAGE :
                $content = '没有更多的内容了';
                break;
            default:
                $content  = $error;
                break;
        }
        $this->returnData['type'] = 'text';
        $this->returnData['data'] = $content;
        $this->returnData['error'] = 1;
    }
    
    private function getContent() {
        $data = $this->returnData['state']['data'];
        $offset = ($data['page'] - 1) * self::PAGECOUNT;
        $category = $this->db->ContentCategory()->where('CategoryKey', $data['keyword'])->fetch();
        if(empty($category)) {
            return self::EEEOR_KEYWORD;
        } else {
            $table = $this->db->CategoryAssocContent()->where('CATEGORYID', $category['CATEGORYID'])->order('AddTime DESC');
            $pages = ceil(count($table) / self::PAGECOUNT);
            if($pages < $data['page']) {
                return self::ERROR_PAGE;
            }
            $items = array();
            $item['Title'] = $category['CategoryName'];
            array_push($items, $item);
            
            $contentid = $table->limit(self::PAGECOUNT, $offset);
            $i = 1;
            foreach($contentid as $id) {
                $content = $this->db->Content('CONTENTID', $id['CONTENTID'])->limit(1)->fetch();
                $item['Title'] = $i . ". " . $content['Title'];
                //$item['Description'] = $content['Content'];
                $item['PicUrl'] = '';
                $item['Url'] = SITE_ROOT . '/content.php?id=' . urlencode($id['CONTENTID']);
                array_push($items, $item);
                $i++;
            }
            $foot['Title'] = '第' . $data['page'] .  '页，共' . $pages . '页';
            if($data['page'] < $pages) {
                $foot['Title'] .= "，回复“下一页”继续浏览";
            }
            array_push($items, $foot);
            $this->returnData['type'] = 'news';
            $this->returnData['data'] = $items;
            return true;
        }
        
    }
}

