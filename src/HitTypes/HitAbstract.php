<?php

namespace Notable\GaMeasurementProtocol\HitTypes;

use Notable\GaMeasurementProtocol\ParameterFormat;

/**
 * @author Daniel Kennedy dkennedy4@gmail.com
 * @package Google Analytics Measurement Protocol V.1
 * @version 1.0
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/reference
 */
abstract class HitAbstract implements HitInterface
{

    /**
     * @var array
     */
    protected $_parameters;

    /**
     * @var array
     */
    private $_required_param_codes;

    /**
     * @var \Notable\GaMeasurementProtocol\ParameterFormat
     */
    private $_ParameterFormat;

    public function __construct()
    {
        $this->_parameters = array();
        $this->_required_param_codes = array('v', 'tid', 'cid', 't');
        $this->setProtocolVersion(1);
        $this->_ParameterFormat = new ParameterFormat();
    }

    /**
     * @param array $child_required_param_codes
     * @return boolean
     */
    public function hasRequiredParameters(array $child_required_param_codes = NULL)
    {
        if ($child_required_param_codes !== NULL) {
            $required_params = array_merge($this->_required_param_codes, $child_required_param_codes);
        } else {
            $required_params = $this->_required_param_codes;
        }
        foreach ($required_params as $param_code) {
            if (!isset($this->_parameters[$param_code])) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * The Protocol version. The current value is '1'.
     * This will only change when there are changes made that are not backwards compatible.
     *
     * Required for all hit types
     *
     * @param string $string
     * @return $this
     */
    public function setProtocolVersion($string)
    {
        $this->_parameters['v'] = $string;
        return $this;
    }

    /**
     * The tracking ID / web property ID. The format is UA-XXXX-Y.
     * All collected data is associated by this ID.
     *
     * Required for all hit types
     *
     * @param string $string
     * @return $this
     */
    public function setTrackingId($string)
    {
        $this->_parameters['tid'] = $string;
        return $this;
    }

    /**
     * When present, the IP address of the sender will be anonymized.
     * For example, the IP will be anonymized if any of the following
     * parameters are present in the payload: &aip=, &aip=0, or &aip=1
     *
     * Optional
     *
     * @param boolean $boolean
     * @return $this
     */
    public function setAnonymizeIp($boolean)
    {
        $this->_parameters['aip'] = $boolean;
        return $this;
    }

    /**
     * Used to collect offline / latent hits.
     * The value represents the time delta (in milliseconds) between
     * when the hit being reported occurred and the time the hit was sent.
     * The value must be greater than or equal to 0. Values greater than
     * four hours may lead to hits not being processed.
     *
     * Optional
     *
     * @param int $integer
     * @return $this
     */
    public function setQueueTime($integer)
    {
        $this->_parameters['qt'] = $integer;
        return $this;
    }

    /**
     * Used to send a random number in GET requests to ensure browsers and
     * proxies don't cache hits. It should be sent as the final parameter
     * of the request since we've seen some 3rd party internet filtering
     * software add additional parameters to HTTP requests incorrectly.
     * This value is not used in reporting.
     *
     * Optional
     *
     * @param string $string
     * @return $this
     */
    public function setCacheBuster($string)
    {
        $this->_parameters['z'] = $this->_prepString($string);
        return $this;
    }

    /**
     * This anonymously identifies a particular user, device, or browser instance.
     * For the web, this is generally stored as a first-party cookie with a two-year
     * expiration. For mobile apps, this is randomly generated for each particular
     * instance of an application install. The value of this field should be a
     * random UUID (version 4) as described in http://www.ietf.org/rfc/rfc4122.txt
     *
     * Required for all hit types
     *
     * @param string $string
     * @return $this
     */
    public function setClientId($string)
    {
        $this->_parameters['cid'] = $this->_prepString($string);
        return $this;
    }

    /**
     * This is intended to be a known identifier for a user provided by the site
     * owner/tracking library user. It may not itself be PII (personally identifiable
     * information). The value should never be persisted in GA cookies or other
     * Analytics provided storage.
     *
     * Optional
     *
     * @param string $string
     * @return $this
     */
    public function setUserId($string)
    {
        $this->_parameters['uid'] = $this->_prepString($string);
        return $this;
    }

    /**
     * The type of hit. Must be one of 'pageview', 'screenview', 'event',
     * 'transaction', 'item', 'social', 'exception', 'timing'.
     *
     * Required for all hit types.
     *
     * @param string $string
     * @return $this
     * @throws \Exception
     */
    public function setHitType($string)
    {
        switch ($string) {
            case 'pageview':
            case 'screenview':
            case 'event':
            case 'transaction':
            case 'item':
            case 'social':
            case 'exception':
            case 'timing':
                break;
            default:
                throw new \Exception('Invalid hit type provided');
        }
        $this->_parameters['t'] = $this->_prepString($string);
        return $this;
    }

    /**
     * Specifies that a hit be considered non-interactive.
     *
     * Optional
     *
     * @param boolean $boolean
     * @return $this
     */
    public function setNonInteractionHit($boolean)
    {
        $this->_parameters['ni'] = $boolean;
        return $this;
    }

    /**
     * The SKU of the product. Product index must be a positive
     * integer between 1 and 200, inclusive.
     *
     * Required for each product in transaction. Parameter two
     * indicates which product is being set. If param two is
     * omitted it defaults to 1.
     *
     * Optional
     *
     * @param string $string
     * @param integer $integer
     * @return $this
     */
    public function setProductSku($string, $integer = 1)
    {
        $param = 'pr' . $integer . 'id';
        $this->_parameters[$param] = trim($string);
        return $this;
    }

    /**
     * The name of the product. Product index must be a positive
     * integer between 1 and 200, inclusive.
     *
     * Required for each product in transaction. Parameter two
     * indicates which product is being set. If param two is
     * omitted it defaults to 1.
     *
     * Optional
     *
     * @param string $string
     * @param integer $integer
     * @return $this
     */
    public function setProductName($string, $integer = 1)
    {
        $param = 'pr' . $integer . 'nm';
        $this->_parameters[$param] = trim($string);
        return $this;
    }

    /**
     * The role of the products included in a hit. If a product
     * action is not specified, all product definitions included
     * with the hit will be ignored. Must be one of: detail, click,
     * add, remove, checkout, checkout_option, purchase, refund.
     *
     * Optional
     *
     * @param string $string
     * @return $this
     * @throws \Exception
     */
    public function setProductAction($string)
    {
        switch ($string) {
            case 'detail':
            case 'click':
            case 'add':
            case 'remove':
            case 'checkout':
            case 'checkout_option':
            case 'purchase':
            case 'refund':
                break;
            default:
                throw new \Exception('Invalid product action provided');
        }
        $this->_parameters['pa'] = $this->_prepString($string);
        return $this;
    }

    /**
     * The transaction ID. This is an additional parameter
     * that can be sent when Product Action is set to 'purchase'
     * or 'refund'.
     *
     * Optional
     *
     * @param string $string
     * @return $this
     */
    public function setTransactionId($string)
    {
        $this->_parameters['ti'] = $this->_prepString($string);
        return $this;
    }

    /**
     * The store or affiliation from which this transaction occurred.
     * This is an additional parameter that can be sent when Product
     * Action is set to 'purchase' or 'refund'.
     *
     * Optional
     *
     * @param string $string
     * @return $this
     */
    public function setAffiliation($string)
    {
        $this->_parameters['ta'] = $this->_prepString($string);
        return $this;
    }

    /**
     * The total value of the transaction, including tax and shipping.
     * If not sent, this value will be automatically calculated using
     * the product quantity and price fields of all products in the
     * same hit. This is an additional parameter that can be sent when
     * Product Action is set to 'purchase' or 'refund'.
     *
     * Optional
     *
     * @param number $number
     * @return $this
     */
    public function setRevenue($number)
    {
        $this->_parameters['tr'] = $this->_ParameterFormat->currency($number);
        return $this;
    }

    /**
     * The transaction coupon redeemed with the transaction. This is
     * an additional parameter that can be sent when Product Action
     * is set to 'purchase' or 'refund'.
     *
     * Optional
     *
     * @param string $string
     * @return $this
     */
    public function setCouponCode($string)
    {
        $this->_parameters['tcc'] = trim($string);
        return $this;
    }

    /**
     * Trims and makes lowercase
     *
     * @param string $string
     * @return string
     */
    protected function _prepString($string)
    {
        if (is_string($string)) {
            $string = trim($string);
            $string = strtolower($string);
        }
        return $string;
    }

}