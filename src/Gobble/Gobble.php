<?php
namespace Gobble;

class Gobble
{
	private $curl ;
	private $uri ;
	private $method ;   //REST VERB
	private $data ; //Array
	private $options ; //Array

	private $responseCode ;
	private $responseBody ;

	/* Options array:
		[ 'basicAuth' => ['username' => '', 'password' => ''] ]
	*/
	public function __construct($uri = '', $method = "GET", $data = array(), $options = array())
	{
		$this->setURI($uri);
		$this->setMethod($method);
		$this->setData($data) ;
		$this->setOptions($options);
	}

	public function setURI($uri)
	{
		$this->uri = $uri ;
	}

	public function setMethod($method)
	{
		$valid_methods = ['GET', 'POST'] ;
		if(in_array($method, $valid_methods))
			$this->method = $method ;
	}

	public function setData($data)
	{
		$this->data = $data ;
	}

	public function setOptions($options)
	{
		$this->options = $options ;
		$this->initialiseOptions();

		$this->curl = curl_init() ;
		if(!$this->curl){
			throw new \Exception('Could not initialise curl.') ;
		}
	}

	public function send()
	{
		//Prepare data
		if($this->method == 'POST')
			$this->preparePOSTPayload() ;
		else if($this->method == 'GET')
			$this->prepareGETPayload() ;

		$this->responseBody = curl_exec($this->curl) ;
		$this->responseCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE) ;
	}

	public function getResponseCode()
	{
		return $this->responseCode ;
	}

	public function getResponseBody()
	{
		return $this->responseBody;
	}

	////////////////////////
	private function initialiseOptions()
	{
		if (isset($options['basicAuth']))
			$this->setBasicAuth();

		$this->initialiseOptionKey('useragent', CURLOPT_USERAGENT, 'Gobble/0.1 (+https://www.ibuildwebapps.com)');
		$this->initialiseOptionKey('follow_location', CURLOPT_FOLLOWLOCATION, true);
		$this->initialiseOptionKey('fail_on_error', CURLOPT_FAILONERROR, true);
		$this->initialiseOptionKey('return_transfer', CURLOPT_RETURNTRANSFER, true);
		$this->initialiseOptionKey('timeout', CURLOPT_TIMEOUT, 10);
		$this->initialiseOptionKey('connect_timeout', CURLOPT_CONNECTTIMEOUT, 10);
		$this->initialiseOptionKey('ssl_verify_host', CURLOPT_SSL_VERIFYHOST, false);
		$this->initialiseOptionKey('ssl_verify_peer', CURLOPT_SSL_VERIFYPEER, false);

	}

	private function initialiseOptionKey($option_key, $curl_method, $default_value)
	{
		if (isset($options[$option_key]))
			curl_setopt($this->curl, $curl_method, $this->options[$option_key]);
		else
			curl_setopt($this->curl, $curl_method, $default_value);
	}

	private function preparePOSTPayload()
	{
		curl_setopt($this->curl, CURLOPT_POST, true) ;
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->data) ;
	}

	private function prepareGETPayload()
	{
		curl_setopt($this->curl, CURLOPT_HTTPGET, true);
	}

	private function setBasicAuth()
	{
		$username = $this->options['basicAuth']['username'] ;
		$password = $this->options['basicAuth']['password'] ;
		curl_setopt($this->curl, CURLOPT_USERPWD, $username . ':' . $password) ;
	}
}