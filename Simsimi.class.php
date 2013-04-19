<?php

/**
 * @author 
 * @license 
 */
class Simsimi  {

	private $cookie = "2D96E7F39FBAB9B28314607D0328D36F";


	/**
	 *
	 */
	function __construct($cookieSeed) {
		if ($cookieSeed)$this->cookie = md5($cookieSeed);
	}

	/**
	 * @param string $key
	 * @return string
	 */
	public function get($key){
		$header = array();
		$header[]= 'Accept: image/gif, image/x-xbitmap, text/html, * '. '/* ';
		$header[]= 'Accept-Language: zh-cn ';
		$header[]= 'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:13.0) Gecko/20100101 Firefox/14.0.1';
		$header[]= 'Host: www.simsimi.com';
		$header[]= 'Connection: Keep-Alive ';
		$header[]= 'Cookie: JSESSIONID='.$this->cookie;

		$Ref="http://www.simsimi.com/talk.htm?lc=ch";
		$Ch = curl_init();
		$Options = array(
				CURLOPT_HTTPHEADER => $header,
				CURLOPT_URL => 'http://www.simsimi.com/func/req?msg='.$key.'&lc=ch',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_REFERER => $Ref,
		);
		curl_setopt_array($Ch, $Options);
		$Message = json_decode(curl_exec($Ch),true);
		curl_close($Ch);
		if($Message['result']=='100' && $Message['response'] <> 'hi'){
			//简单过滤几个广告
			str_replace('xhjchat', ' 福大人 ', $Message['response']);
			str_replace('simsimi', ' 福大人 ', $Message['response']);
			str_replace('三八三三三九零九三', '7784257', $Message['response']);
			if (strstr($Message["response"],"号love")) {
				$Message["response"] = "...";
			}
			return $Message['response'];
		}else{
			return '你说的什么啊？';
		}
	}
}


?>
