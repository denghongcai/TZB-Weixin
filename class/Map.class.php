<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Map extends TZB_Base {
    const APIURL = 'http://apis.map.qq.com/uri/v1/routeplan?';
    const GEOCODERAPI = 'http://apis.map.qq.com/ws/geocoder/v1/?';
    const APIKEY = 'M3BBZ-XNDRJ-6LLF6-KG5JG-GY3A5-2UFNP';
    
    const BD_APIURL = 'http://api.map.baidu.com/direction?';
    
    
    const PIC_BUS = 'http://tzb-weixin.dhc.house/pic/bus.png';
    const PIC_CAR = 'http://tzb-weixin.dhc.house/pic/car.png';
    const PIC_WALK = 'http://tzb-weixin.dhc.house/pic/walking.png';
    private $data = array(
           'fromcoord' => '',
           'from' => '',
           'to' => '',
           'tocoord' => '',
           'policy' => '1',
           'referer' => 'tzbweixin',
    );
    private $location;

    public function __construct(&$data, &$location) {
        $this->data = array_merge($this->data, $data);
        $this->location = $location;
        $this->returnData['state']['keyword'] = 'Map';
    }
    
    public function getReturn() {
        if(!empty($this->data['fromcoord'])) {
            $this->data['tocoord'] = $this->location['x'] . ',' . $this->location['y'];
            $this->data['to'] = $this->getName($this->data['tocoord']);
            $this->returnData['type'] = 'news';
            $this->returnData['data'] = $this->getNews();
            $item = array('Title' => '继续发送其他想去的地方可以查看更多路线哟～');
            array_push($this->returnData['data'], $item);
            $this->returnData['state']['keyword'] = false;
            $this->returnData['state']['data'] = NULL;
        } else {
            $this->data['fromcoord'] = $this->location['x'] . ',' . $this->location['y'];
            $this->data['from'] = $this->getName($this->data['fromcoord']);
            $this->returnData['type'] = 'text';
            $this->returnData['data'] = '请发送【目的地】的位置信息';
            $this->returnData['state']['keyword'] = 'Map';
            $this->returnData['state']['data'] = $this->data;
        }
        return $this->returnData;
    }
    
    private function getUrl($type) {
        $this->data['type'] = $type;
        return self::APIURL . http_build_query($this->data);
    }
    
    private function getUrlBD($type) {
        $data['origin'] = 'latlng:' . $this->data['fromcoord'] . "|name:" . $this->data['from'];
        $data['destination'] = 'latlng:' . $this->data['tocoord'] . "|name:" . $this->data['to'];
        $data['output'] = 'html';
        $data['coord_type'] = 'gcj02';
        $data['region'] = '武汉';
        $data['mode'] = $type;
        $data['src'] = 'tzbweixin';
        return self::BD_APIURL . http_build_query($data);
    }

        private function getNews() {
        $items = array();
            array_push($items, array(
                'Title' => $this->data['from'] . '->' . $this->data['to'],
            ));
            array_push($items, array(
                'Title' => '公交导航',
                'PicUrl'    =>  self::PIC_BUS,
                'Url' => $this->getUrlBD('transit'),
            ));
            array_push($items, array(
                'Title' => '驾车导航',
                'PicUrl'    =>  self::PIC_CAR,
                'Url' => $this->getUrlBD('driving'),
            ));
            array_push($items, array(
                'Title' => '步行导航',
                'PicUrl'    =>  self::PIC_WALK,
                'Url' => $this->getUrlBD('walking'),
            ));
            return $items;
    }
    
    private function getName($location) {
        $params = array(
            'location' => $location,
            'get_poi'   => 0,
            'key'   => self::APIKEY,
        );
        $url = self::GEOCODERAPI . http_build_query($params);
        $jdata = file_get_contents($url);
        $data = json_decode($jdata, true);
        if($data['status'] != 0) {
            return $location;
        } else {
            return $data['result']['formatted_addresses']['rough'];
        }
    }
}