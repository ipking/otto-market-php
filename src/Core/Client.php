<?php

namespace OttoMarket\Core;

abstract class Client{
	
	const URI_API = 'https://api.otto.market';
	
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	
	private static $success_codes = [200,201,204];
	
	protected static $callback;
	
	protected $method;
	
	protected $url;
	
	protected $data;
	
	protected $client_response;
	
	protected $response_code;
	
	protected $access_token;
	
	/**
	 * @param $cb
	 */
	public static function setSendCallback($cb){
		self::$callback = $cb;
	}
	
	
	/**
	 * @return string
	 */
	public function getMethod(){
		return $this->method;
	}
	
	/**
	 * @return string
	 */
	public function getUrl(){
		return $this->url;
	}
	
	/**
	 * @return string
	 */
	public function getData(){
		return $this->data;
	}
	
	/**
	 * @return string
	 */
	public function getResponse(){
		return $this->client_response;
	}
	
	/**
	 * @param string $access_token
	 */
	public function setAccessToken($access_token){
		$this->access_token = $access_token;
	}
	
	/**
	 * @param string $uri
	 * @param array $requestOptions
	 * @return array
	 * @throws HttpException|\Exception
	 */
	protected function send($uri, $requestOptions = []){
		$this->method = strtoupper($requestOptions['method']);
		$this->url = self::URI_API.$uri;
		
		if (isset($requestOptions['query'])) {
			$this->url .= '?' . http_build_query($requestOptions['query']);
		}
		
		$header_arr = [];
		if($this->access_token){
			$header_arr[] = 'Authorization: Bearer '.$this->access_token;
		}
		
		switch($this->method){
			case self::METHOD_GET:
				$opt = array(
					CURLOPT_HTTPHEADER     => $header_arr,
				);
				
				return $this->execute($this->url,$opt);
			case self::METHOD_POST:
				$data = [];
				if($requestOptions['json']){
					$data = json_encode($requestOptions['json']);
					$header_arr[] = 'Content-Type: application/json';
				}
				if($requestOptions['form']){
					$data = http_build_query($requestOptions['form']);
					$header_arr[] = 'Content-Type: application/x-www-form-urlencoded';
				}
				$opt = array(
					CURLOPT_POST           => true,
					CURLOPT_HTTPHEADER     => $header_arr,
					CURLOPT_POSTFIELDS     => $data,
				);
				$this->data = json_encode($requestOptions['json']);
				return $this->execute($this->url,$opt);
			default :
				throw new \Exception('Not support method :'.$this->method);
		}
		
	}
	
	/**
	 * @param string $url
	 * @param array $opt
	 * @return array|mixed
	 * @throws HttpException
	 */
	public function execute($url, $opt){
		$this->response_code = '';
		$this->client_response = Curl::execute($url,$opt);
		list($response_body,$response_code) = $this->client_response;
		$this->response_code = $response_code;
		
		if(is_callable(self::$callback)){
			$callback = self::$callback;
			$callback($this);
		}
		
		return $response_body?json_decode($response_body, true):'';
	}
	
	/**
	 * @return bool
	 */
	public function isSuccess(){
		return in_array($this->response_code,self::$success_codes);
	}
}