<?php

namespace Notable\GaMeasurementProtocol\HitTypes;

use Notable\GaMeasurementProtocol\HitTypes\HitAbstract;

/**
 * @author Daniel Kennedy dkennedy4@gmail.com
 * @package Google Analytics Measurement Protocol V.1
 * @version 1.0
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/reference
 */
class Event extends HitAbstract 
{
	
	/**
	 * @var array
	 */
	private $_required_param_codes;
	
	public function __construct()
	{		
		parent::__construct();		
		$this->_required_param_codes = array('ec', 'ea');		
		$this->setHitType('event');		
	}
	
	/**
	 * @return NULL|multitype:
	 */
	public function getParameters(){
		
		if (!$this->hasRequiredParameters()){
			
			return NULL;
			
		}
		
		return $this->_parameters;
		
	}
	
	/**
	 * @see \Notable\GaMeasurementProtocol\HitTypes\HitAbstract::hasRequiredParameters()
	 */
	public function hasRequiredParameters(array $child_required_param_codes = NULL){
		
		if ($child_required_param_codes !== NULL){
				
			$required_params = array_merge($this->_required_param_codes, $child_required_param_codes);
				
		}
		else {
				
			$required_params = $this->_required_param_codes;
				
		}
		
		return parent::hasRequiredParameters($required_params);
		
	}
	
	/**
	 * Specifies the event category.
	 * Must not be empty.
	 * Max length 150 Bytes
	 *
	 * Optional
	 *
	 * @param string $string
	 */
	public function setEventCategory($string){
	
		if ($string === ''){
				
			trigger_error('Event category cannot be empty', E_USER_WARNING);
				
		}
	
		if (strlen($string) > 150){
				
			trigger_error('Event category must be less than 150 bytes', E_USER_WARNING);
				
		}
	
		$this->_parameters['ec'] = $this->_prepString($string);
	
		return $this;
	
	}
	
	/**
	 * Specifies the event action.
	 * Must not be empty.
	 * Max length 500 Bytes
	 *
	 * Optional
	 *
	 * @param string $string
	 */
	public function setEventAction($string){
	
		if ($string === ''){
	
			trigger_error('Event action cannot be empty', E_USER_WARNING);
	
		}
	
		if (strlen($string) > 500){
	
			trigger_error('Event action must be less than 500 bytes', E_USER_WARNING);
	
		}
	
		$this->_parameters['ea'] = $this->_prepString($string);
	
		return $this;
	
	}
	
	/**
	 * Specifies the event label.
	 * Max length 500 Bytes
	 *
	 * Optional
	 *
	 * @param string $string
	 */
	public function setEventLabel($string){
	
		if (strlen($string) > 500){
	
			trigger_error('Event label must be less than 500 bytes', E_USER_WARNING);
	
		}
	
		$this->_parameters['el'] = $this->_prepString($string);
	
		return $this;
	
	}
	
	/**
	 * Specifies the event value. Values must be non-negative.
	 *
	 * Optional
	 *
	 * @param number $number
	 */
	public function setEventValue($number){
		
		if (is_numeric($number)){

			if ($number < 0){
				
				trigger_error('Event value must be non-negative', E_USER_WARNING);
				
			}
	
		}
		else {
			
			trigger_error('Event value must be a number', E_USER_WARNING);
			
		}
	
		$this->_parameters['ev'] = $number;
	
		return $this;
	
	}
	
}