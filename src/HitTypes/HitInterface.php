<?php

namespace Notable\GaMeasurementProtocol\HitTypes;

/**
 * @author Daniel Kennedy dkennedy4@gmail.com
 * @package Google Analytics Measurement Protocol V.1
 * @version 1.0
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/reference
 */
interface HitInterface {
	
	public function hasRequiredParameters(array $child_required_param_codes = NULL);
	
	public function getParameters();
	
}