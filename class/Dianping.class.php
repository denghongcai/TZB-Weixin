<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require(BASEPATH . '/class/DianpingAPI.class.php');


class Dianping {
	
	const ERROR_LOCATION = 'ERROR_LOCATION';
	const ERROR_GET = 'ERROR_GET';
	
	private $weObj;
	private $apiTool;
	private static $defaultParams =  array('format'=>'json','city'=>'武汉','limit'=>'5','is_local'=>'1');
	private $params = array(
		'latitude' => '0',
		'longitude' => '0',
		'radius' =>  '2000',
		'limit' => '5',
		'page' => '1',
		'sort' => '7',
	);
	
	
	public function __construct($weObj, (array)$dianpingCfg, $x, $y, $page = 1, $sort = 7) {
		$this->weObj = $weObj;
		$this->apiTool = new DianpingApiTool($dianpingCfg['apiUrl'], $dianpingCfg['appKey'], $dianpingCfg['appSecret'], self::$defaultParams);
		$this->params['latitude'] = $x;
		$this->params['longitude'] = $y;
		$this->params['page'] = $page;
		$this->params['sort'] = $sort;
	}
	
	public function doDianping() {
		if(empty($this->params['latitude']) || empty($this->params['longitude'])) {
			$this->showError(ERROR_LOCATION);
		} else {
			$revArr = $this->getDianping();
			if(empty($revArr))
				$this->showError(ERROR_GET);
			else {
				$this->showDianping($revArr['businesses']);
			}
		}
		return true;
	}
	
	private function showDianping($data) {
			$items = array();
			foreach($data as $row) {
				$item['Title'] = $row['name'];
				$item['Description'] = $row['address'];
				$item['PicUrl'] = $row['s_photo_url'];
				$item['Url'] = $row['business_url'];
				array_push($items, $item);
			}
			$this->news($items)->reply();
	}
	
	private function showError($error) {
		$this->text($error)->reply();
	}
	
	private function getDianping() {
		$jsonObj = $api->requestApi($params);
		return (array)$jsonObj;
	}
}
