<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class WechatVote {

	const BEGIN_VOTE_KEYWORD = '主题曲';
	const GET_OPTION_KEYWORD = '试听';
	const FINISH_VOTE_KEYWORD = '投票';
	const ERROR_OPTION = 1;
	const ERROR_RPT = 2;

	private static $options = array(
		1 => array(
				'Title'=>'时间都去哪儿了',
				'Description'=>'电影《私人订制》插曲, 电影《私人订制》插曲, 电视剧《老牛家的战争》主题曲',
				'MusicUrl'=>'http://101.littlenut.sinaapp.com/weixin/test.mp3',
				'HQMusicUrl'=>'http://101.littlenut.sinaapp.com/weixin/test.mp3'
			),
		2 => array(
				'Title'=>'test',
				'Description'=>'des',
				'MusicUrl'=>'url',
				'HQMusicUrl'=>'hurl'
			),

		);

	private $weObj;
	private $text = '';
	private $uid = '';

	public function __construct($weObj) {

		$this->weObj = $weObj;
		$this->text = $weObj->getRevContent();
		$this->uid = $weObj->getRevFrom();
	}

	public function doVote() {

		if(trim($this->text) == self::BEGIN_VOTE_KEYWORD) {
			$this->showOptions();
			return true;
		}

		if(stripos($this->text, self::GET_OPTION_KEYWORD) !== false) {
			$option = $this->getOptionFromText();
			if($option !== false) {
				$this->showOptionDetails($option);
			}
			else {
				$this->showError(self::ERROR_OPTION);
			}
			return ture;
		}
		else if(stripos($this->text, self::FINISH_VOTE_KEYWORD) !== false) {
			$option = $this->getOptionFromText();
			if($option !== false) {
				if($this->saveVote($option))
					$this->showSuccess();
				else
					$this->showError(self::ERROR_RPT);
			}
			else {
				$this->showError(self::ERROR_OPTION);
			}
			return ture;

		}
		else {
			return false;
		}

	}

	private function showOptions() {
		$content = serialize(self::$options);
		$this->weObj->text($content)->reply();
	}

	private function showOptionDetails($option) {
		if(isset(self::$options[$option])) {

			$row = self::$options[$option];
			$this->weObj->music($row['Title'], $row['Description'], $row['MusicUrl'], $row['HQMusicUrl'])->reply();
			return true;
		}
		else {
			$this->showError($option);
			return false;
		}
	}

	private function showSuccess($option) {

	}

	private function showError($error) {
		switch ($error) {
			case ERROR_OPTION:
				$content = 'ERROR_OPTION';
				break;
			case ERROR_RPT:
				$content = 'ERROR_RPT';
				break;

			default:
				$content = $error;
				break;
		}
		$this->weObj->text($content)->reply();
	}

	private function getOptionFromText() {
		preg_match_all('/\d+/',$this->text, $number, PREG_SET_ORDER );
		if(count($number) > 0)
			return $number[0][0];
		else
			return false;
	}

	private function saveVote($option) {

	}
}