<?php

namespace Notable\GaMeasurementProtocol;

use Notable\GaMeasurementProtocol\HitTypes\HitInterface;

/**
 * Class PostRequest
 *
 * @package Notable\GaMeasurementProtocol
 */
class PostRequest {
	
	/**
	 * @var Uri
	 */
	private $_Uri;
	
	/**
	 * @var string
	 */
	private $_user_agent;

	/**
	 * @var array
     */
	private $_curl_info;

	/**
	 * @param Uri $Uri
	 * @param $user_agent
     */
	public function __construct(Uri $Uri, $user_agent)
	{
		$this->setUserAgent($user_agent);
		$this->_Uri = $Uri;			
	}
	
	/**
	 * @param HitInterface $HitObject
	 * @return boolean
	 */
	public function send(HitInterface $HitObject)
	{		
		$payload = $HitObject->getPayload();
		$HttpRequest = new HttpRequest($this->_Uri, $payload, $this->_user_agent);
		$HttpRequest->send();		
		$this->_curl_info = $HttpRequest->getCurlInfo();
		/** True if code is in 200 range */
		return ($this->_curl_info['http_code'] > 199 && $this->_curl_info['http_code'] < 300) ? TRUE : FALSE;
	}

	/**
	 * @param string $string
	 * @return $this
	 */
	public function setUserAgent($string)
	{		
		if (is_string($string)){			
			$this->_user_agent = $string;			
		}		
		return $this;		
	}
	
	/**
	 * @return string
	 */
	public function getUserAgent()
	{		
		if (isset($this->_user_agent)){			
			return $this->_user_agent;			
		}		
	}

	/**
	 * @return array
     */
	public function getCurlInfo()
	{
		return $this->_curl_info;
	}
	
}