<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Weather extends TZB_Base {
    const APIURL= "http://api.map.baidu.com/telematics/v3/weather?";
    private $params = array(
        'location' => '114.441244,30.530082',
        'output' => 'json',
        'ak' => '4b8e00b132f74675078640da867817c5',
    );
    
    public function __construct($location = '114.441244,30.530082') {
        $this->params['location'] = $location;
        $this->returnData['state']['keyword'] = 'Weather';
        $this->returnData['state']['data'] = $location;
    }
    
    public function getReturn() {
        $weather = $this->getWeather();
        
        if($weather['error'] != 0) {
            $this->returnData['type'] = 'text';
            $this->returnData['data'] = $weather['status'];
        } else {
            $this->returnData['type'] = 'text';
            $this->returnData['data'] = $this->showSuccess($weather);
        }
        return $this->returnData;
    }
    
    private function showSuccess($data) {
        if($data['error']) {
            return false;
        }
        $data = $data['results'][0];
        $content = $data['currentCity'] . " 生活提示\n【PM2.5】:" . $data['pm25'] . "\n";
        foreach($data['index'] as $row) {
            $content .= "【$row[tipt]】:$row[des] \n";
        }
        $content .= "【天气状况】:\n";
        foreach($data['weather_data'] as $row) {
            $content .= "$row[date]  $row[weather]，$row[wind]，$row[temperature]\n";
        }
        return $content;
    }
    
    protected function showError($error) {
        ;
    }
    
    private function getWeather() {
        $url = self::APIURL . http_build_query($this->params);
        $jsondata = file_get_contents($url);
        $data = json_decode($jsondata, true);
        return $data;
    }
}
