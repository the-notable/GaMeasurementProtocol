<?php

namespace Notable\GaMeasurementProtocol\HitTypes;

use Exception;

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
     * @return array|null
     */
    public function getParameters()
    {
        if (!$this->hasRequiredParameters()) {
            return null;
        }
        return $this->_parameters;
    }

    /**
     * @param array $child_required_param_codes
     * @return bool
     */
    public function hasRequiredParameters(array $child_required_param_codes = NULL)
    {
        if ($child_required_param_codes !== NULL) {
            $required_params = array_merge($this->_required_param_codes, $child_required_param_codes);
        } else {
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
     * @throws Exception
     * @return $this
     */
    public function setEventCategory($string)
    {
        if ($string === '') {
            throw new Exception('Event category cannot be empty');
        }
        if (strlen($string) > 150) {
            throw new Exception('Event category must be less than 150 bytes');
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
     * @return $this
     * @throws \Exception
     */
    public function setEventAction($string)
    {
        if ($string === '') {
            throw new Exception('Event action cannot be empty');
        }
        if (strlen($string) > 500) {
            throw new Exception('Event action must be less than 500 bytes');
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
     * @return $this
     * @throws \Exception
     */
    public function setEventLabel($string)
    {
        if (strlen($string) > 500) {
            trigger_error('Event label must be less than 500 bytes', E_USER_WARNING);
            throw new Exception('Event label must be less than 500 bytes');
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
     * @return $this
     * @throws \Exception
     */
    public function setEventValue($number)
    {
        if (is_numeric($number)) {
            if ($number < 0) {
                throw new \Exception('Event value must be non-negative');
            }
        } else {
            throw new \Exception('Event value must be a number');
        }
        $this->_parameters['ev'] = $number;
        return $this;
    }

}