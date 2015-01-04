<?php

namespace Notable\GaMeasurementProtocol;

use Notable\GaMeasurementProtocol\HitTypes\HitInterface;

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
		$curl_result = $HttpRequest->getCurlInfo();		
		/** True if code is in 200 range */
		return ($curl_result['http_code'] > 199 && $curl_result['http_code'] < 300) ? TRUE : FALSE;		
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
	
}