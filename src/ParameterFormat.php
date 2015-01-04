<?php

namespace Notable\GaMeasurementProtocol;

/**
 * Provides methods to format data according to
 * requirements of Google's Measurement Protocol.
 * 
 * @author Daniel Kennedy dkennedy4@gmail.com
 * @package Google Analytics Measurement Protocol V.1
 * @version 1.0
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/reference
 */
class ParameterFormat {
	
	/**
	 * Returns number formatted according to Google's requirements:
	 * 
	 * Used to represent the total value of a currency. 
	 * A decimal point is used as a delimiter between the
	 * whole and fractional portion of the currency. The 
	 * precision is up to 6 decimal places. The following 
	 * is valid for a currency field:
	 * 
	 * 1000.000001
	 * 
	 * @param number $number
	 * @return boolean|number
	 */
	public function currency($number){
		
		if (!is_numeric($number)){
			
			$type = gettype($number);
			
			trigger_error("Parameter one expected type 'number', '$type' given.", E_USER_WARNING);
			
			return FALSE;
			
		}
		
		return round($number, 6);
		
	}
	
}