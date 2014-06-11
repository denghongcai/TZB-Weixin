<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 微信平台投票功能（音乐）
 * @author  chl
 *
 * 在options数组中填入候选项
 */
class WechatVote {

    const KEYWORD_BEGIN_VOTE = '吉祥物';
    //const KEYWORD_GET_OPTION = '试听';
    const KEYWORD_FINISH_VOTE = 'TP';
    const ERROR_OPTION = 'ERROR_OPTION';
    const ERROR_RPT = 'ERROR_RPT';
    const ERROR_OVERTIMES = 'ERROR_OVERTIMES';
    
    const TEXT_SUCC = "恭喜您，已经成功为%s号作品投票成功！";
    const TEXT_RPT = "不好意思哦亲，不能重复投票～";
    const TEXT_OVERTIMES = "不好意思哦亲，最多只能投三票哦，多投作废票计～";
    const TEXT_OPTION = "不好意思哦亲，没有这个选项～";
    
    const MAX_VOTES = 3;
    const MAX_OPTION = 15;

    /**
     * 选项
     * @var array
     */
    private static $options = array(
        0 => array(
            'Title' => '为创青春大赛选出你心仪的吉祥物',
            'Description' => '  自3月26日起，“创青春”全国大学生创业大赛组委会面向全国发布征集2014年“创青春”全国大学生创业大赛吉祥物的通知，截至目前，共收到来自全国各省市的100余件优秀作品。经大赛组委会初步评选，共有15件作品进入最终投票环节，现面向社会进行公开投票。
       15个吉祥物形象积极向上，令人耳目一新。为您支持的作品投票，选出“创青春”大赛的吉祥物吧！',
            //'PicUrl' => 'http://tzb-weixin.dhc.house/music/Sparks_Fly.mp3',
            'Url' => 'http://mp.weixin.qq.com/s?__biz=MzA4MDM3NjExMQ==&mid=200173479&idx=1&sn=7c91e7feb70cbf4e5c4d71c6635f82f0#rd',
        ),
    );
    private static $url = 'http://mp.weixin.qq.com/s?__biz=MzA4MDM3NjExMQ==&mid=200173479&idx=1&sn=7c91e7feb70cbf4e5c4d71c6635f82f0#rd';
    
    private $weObj;
    private $text = '';
    private $uid = '';

    /**
     * 构造函数
     * @param Wechat $weObj Wechat类的实例
     */
    public function __construct($weObj) {

        $this->weObj = $weObj;
        $this->text = $weObj->getRevContent();
        $this->uid = $weObj->getRevFrom();
    }

    /**
     * 从外部调用doVote，处理用户回复中包含查看候选项或投票的关键字的部分
     * @return bool 是否包含关键字
     */
    public function doVote() {

        if (trim($this->text) == self::KEYWORD_BEGIN_VOTE) {
            $this->showOptions();
            return true;
        }

//        if (stripos($this->text, self::KEYWORD_GET_OPTION) !== false) {
//            $option = $this->getOptionFromText();
//            if ($option !== false) {
//                $this->showOptionDetails($option);
//            } else {
//                $this->showError(self::ERROR_OPTION);
//            }
//            return ture;
//        } else 
        if (stripos($this->text, self::KEYWORD_FINISH_VOTE) !== false) {
            $option = $this->getOptionFromText();
            if ($option !== false && $option <=self::MAX_OPTION && $option > 0) {
                $state = $this->saveVote($option, $count);
                if ($state === true) {
                    $this->showSuccess($option, $count);
                } else {
                    $this->showError($state);
                }
            }
            else {
                $this->showError(self::ERROR_OPTION);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 向微信客户端展示候选项列表
     */
    private function showOptions() {

        $this->weObj->news(self::$options)->reply();
    }

    /**
     * 展示具体的选项
     * @param  int $option 选项的编号
     * @return bool        编号是否正确
     */
    private function showOptionDetails($option) {
        if (isset(self::$options[$option])) {

            $row = self::$options[$option];
            $this->weObj->music($row['Title'], $row['Description'], $row['MusicUrl'], $row['HQMusicUrl'])->reply();
            return true;
        } else {
            $this->showError(ERROR_OPTION);
            return false;
        }
    }

    /**
     * 投票成功
     * @param  int $option 选项的编号
     */
    private function showSuccess($option, $count) {
        $count = self::MAX_VOTES - $count;
        $content = sprintf(self::TEXT_SUCC, $option) . "\n您还有 $count 次投票机会";
        $this->weObj->text($content)->reply();
    }

    /**
     * 向客户端展示错误信息
     * @param  string $error 错误代码
     */
    private function showError($error) {
        switch ($error) {
            case self::ERROR_OPTION:
                $content = self::TEXT_OPTION;
                break;
            case self::ERROR_RPT:
                $content = self::TEXT_RPT;
                break;
            case self::ERROR_OVERTIMES:
                $content = self::TEXT_OVERTIMES;
                break;
            default:
                $content = 'error:' . $error;
                break;
        }
        $this->weObj->text($content)->reply();
    }

    /**
     * 从回复中取出编号
     * @return int 取出的第一个编号
     */
    private function getOptionFromText() {
        $number = array();
        preg_match_all('/\d+/', $this->text, $number, PREG_SET_ORDER);
        if (count($number) > 0) {
            return (int) $number[0][0];
        } else {
            return false;
        }
    }

    /**
     * 保存投票结果
     * @param  int $option 投票编号
     * @return bool        是否投票成功
     */
    private function saveVote($option, &$count) {

        $db = DB::connect();
        $count = $db->tzbvote('uid', $this->uid)->count('*');
        if ($count >= self::MAX_VOTES) {
            return self::ERROR_OVERTIMES;
        } else if($db->tzbvote(array('uid'=>  $this->uid, 'vote'=>$option))->count('*') > 0) {
            return self::ERROR_RPT;
        } else {
            $data = array('uid' => $this->uid, 'vote' => $option);
            $db->tzbvote()->insert($data);
            $count++;
            return true;
        }
    }

}
