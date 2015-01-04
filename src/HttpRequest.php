<?php

namespace Notable\GaMeasurementProtocol;

/**
 * @author Daniel Kennedy dkennedy4@gmail.com
 * @package Google Analytics Measurement Protocol V.1
 * @version 1.0
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/reference
 */
class HttpRequest
{
	
	/**
	 * @var string
	 */
	private $_uri;
	
	/**
	 * @var string
	 */
	private $_payload;
	
	/**
	 * @var string
	 */
	private $_user_agent;
	
	/**
	 * @var array
	 */
	private $_curl_info;
	
	/**
	 * @var boolean
	 */
	private $_response;

	/**
	 * @param Uri $Uri
	 * @param string $payload
	 * @param string $user_agent
	 */
	public function __construct(Uri $Uri, $payload, $user_agent)
	{
		$this->_uri = $Uri->get();
		$this->_payload = $payload;
		$this->_user_agent = $user_agent;
	}

	/**
	 * Uses cURL to send Http Request
     */
	public function send()
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_USERAGENT, $this->_user_agent);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $this->_uri);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type: application/x-www-form-urlencoded'));
		curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
		curl_setopt($ch,CURLOPT_POST, TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $this->_payload);
		$this->_response = curl_exec($ch);
		$this->_curl_info = curl_getinfo($ch);
		curl_close($ch);
	}

	/**
	 * Returns information about last cURL Http Request
	 *
	 * @return array|null
     */
	public function getCurlInfo()
	{
		if (!isset($this->_curl_info)){
			return null;
		}
		return $this->_curl_info;
	}
	
	/**
	 * @return null|boolean
	 */
	public function getResponse()
	{
		if (!isset($this->_response)){
			return null;
		}
		return $this->_response;
	}
	
}