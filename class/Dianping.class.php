<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require(BASEPATH . '/class/DianpingAPI.class.php');

class Dianping {

    const ERROR_LOCATION = 'ERROR_LOCATION';
    const ERROR_GET_EMPTY = 'ERROR_GET_EMPTY';
    const ERROR_GET_ERROR = 'ERROR_GET_ERROR';

    private $weObj;
    private $apiTool;
    private $params = array(
        'latitude' => '0',
        'longitude' => '0',
        'radius' => '2000',
        'limit' => '5',
        'page' => '1',
        'sort' => '7',
    );

    public function __construct($weObj, $dianpingCfg, $x, $y, $page = 1, $sort = 7) {
        $this->weObj = $weObj;
        $this->apiTool = new DianpingApiTool($dianpingCfg['apiUrl'], $dianpingCfg['appKey'], $dianpingCfg['appSecret']);
        $this->params['latitude'] = $x;
        $this->params['longitude'] = $y;
        $this->params['page'] = $page;
        $this->params['sort'] = $sort;
    }

    public function doDianping() {

        if (empty($this->params['latitude']) || empty($this->params['longitude'])) {
            $this->showError(ERROR_LOCATION);
        } else {
            $revArr = $this->getDianping();
            if (empty($revArr)) {
                $this->showError(ERROR_GET_EMPTY);
            } else if ($revArr['status'] == 'ERROR') {
                 $this->showError(ERROR_GET_ERROR);
            } else {
                $this->showDianping($revArr);
            }
        }
        return true;
    }

    private function showDianping($data) {
        $items = array();

        foreach ($data['businesses'] as $row) {
            $item['Title'] = $row['name'] . ' 距离' . $row['distance'] . '米';
            $item['Description'] = $row['address'];
            $item['PicUrl'] = $row['s_photo_url'];
            $item['Url'] = $row['business_url'];
            array_push($items, $item);
        }
        $tip['Title'] = '为您找到' . $data['total_count'] . '家商户（第' . $this->params['page'] .  '页，共' . 
                ceil($data['total_count'] / $this->params['limit']) . '页），回复“下一页”继续浏览  以上数据来源“大众点评”';
        array_push($items, $tip);
        
        $this->weObj->news($items)->reply();
    }

    private function showError($error) {
        switch ($error) {
            case ERROR_GET_ERROR :
                $content = '获取大众点评消息失败';
                break;
            default:
                $content  = $error;
                break;
        }
        $this->weObj->text($content)->reply();
    }

    private function getDianping() {
        $jsonObj = $this->apiTool->requestApi($this->params);
        return (array) $jsonObj;
    }

}
