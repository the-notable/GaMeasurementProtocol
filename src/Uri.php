<?php

namespace Notable\GaMeasurementProtocol;

/**
 * Measurement Protocol API Date: August 1, 2014.
 * 
 * SSL is optional
 * 
 * @author Daniel Kennedy dkennedy4@gmail.com
 * @package Google Analytics Measurement Protocol V.1
 * @version 1.0
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/reference
 */
class Uri 
{
	
	/**
	 * @var boolean
	 */
	private $_use_ssl;
	
	/**
	 * @var string
	 */
	private $_endpoint;
	
	/**
	 * @var string
	 */
	private $_ssl_endpoint;
	
	public function __construct()
	{	
		$this->_use_ssl = false;
		$this->_endpoint = 'http://www.google-analytics.com/collect';	
		$this->_ssl_endpoint = 'https://ssl.google-analytics.com/collect';	
	}

	/**
	 * @return string
     */
	public function get()
	{		
		return ($this->_use_ssl === true) ? $this->_ssl_endpoint : $this->_endpoint;
	}
	
	/**
	 * @param boolean $boolean
	 * @return HttpRequest
	 */
	public function setUseSsl($boolean)
	{	
		if (is_bool($boolean)){				
			$this->_use_ssl = $boolean;				
		}	
		return $this;	
	}
	
}