<?php

namespace Notable\GaMeasurementProtocol;

use Notable\GaMeasurementProtocol\HitTypes\HitInterface;

/**
 * Creates a payload string.
 * 
 * Measurement Protocol API Date: August 1, 2014.
 * 
 * @author Daniel Kennedy dkennedy4@gmail.com
 * @package Google Analytics Measurement Protocol V.1
 * @version 1.0
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/reference
 */
class Payload {
	
	/**
	 * @var \Notable\GaMeasurementProtocol\HitTypes\HitInterface
	 */
	private $_HitObject;
	
	/**
	 * @param HitInterface $HitObject
	 */
	public function __construct(HitInterface $HitObject){
		
		$this->_HitObject = $HitObject;
		
	}
	
	/**
	 * @return string
	 */
	public function get(){
		
		$payload = '';
		
		$parameters = $this->_HitObject->getParameters();
		
		/* The 'z' parameter is Cache Busting and must be at the end */
		if (isset($parameters['z'])){
			
			$cache_busting = $parameters['z'];
			
			unset($parameters['z']);
						
		}
		
		$ii = 0;
		
		foreach ($parameters as $key => $param){
			
			$payload .= ($ii === 0) ? '' : '&';
			
			$payload .= $key.'=';
			
			$payload .= urlencode($param);
			
			$ii++;
			
		}
		
		/* Check if Cache Busting was pulled earlier */
		if (isset($cache_busting)){
			
			$payload .= '&z='.$cache_busting;
			
		}
		
		return utf8_encode($payload);
		
	}
	
}