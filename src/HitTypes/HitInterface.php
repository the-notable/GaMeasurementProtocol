<?php

namespace Notable\GaMeasurementProtocol\HitTypes;

/**
 * @author Daniel Kennedy dkennedy4@gmail.com
 * @package Google Analytics Measurement Protocol V.1
 * @version 1.0
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/reference
 */
interface HitInterface
{

	/**
	 * @param array $child_required_param_codes
	 * @return boolean
     */
	public function hasRequiredParameters(array $child_required_param_codes = NULL);

	/**
	 * @return mixed
     */
	public function getParameters();

	/**
	 * @return string
     */
	public function getPayload();
	
}