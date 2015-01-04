<?php

namespace Notable\GaMeasurementProtocol\HitTypes;

/**
 * Class HitFactory
 * @package Notable\GaMeasurementProtocol\HitTypes
 */
class HitFactory
{
	
	/**
	 * @var HitAbstract
	 */
	private $_ReturnHit;
	
	/**
	 * @var string
	 */
	private $_tracking_id;
	
	/**
	 * @var string
	 */
	private $_client_id;

	/**
	 * @var string
     */
	private $_hit_type;

	/**
	 * @param string $hit_type
	 * @param string $tracking_id
	 * @param boolean|string $client_id
	 * @return HitAbstract|NULL
	 * @throws \Exception
	 */
	public function get($hit_type, $tracking_id, $client_id)
	{
		$this->resetState();
		$this->setTrackingId($tracking_id);
		$this->setClientId($client_id);
		if($this->setHitType($hit_type) === null){
			return null;
		}
		return $this->_ReturnHit
			->setTrackingId($this->_tracking_id)
			->setClientId($this->_client_id);
	}

	/**
	 * @param string $hit_type
	 * @return null
	 * @throws \Exception
     */
	private function setHitType($hit_type)
	{
		if (!is_string($hit_type)){
			$type = gettype($hit_type);
			throw new \Exception("Param must be of type 'string', '$type' provided");
		}
		$this->_hit_type = $hit_type;
		switch ($this->_hit_type){
			case 'event':
				$this->_ReturnHit = new Event();
				break;

			default:
				return null;
		}
	}

	/**
	 * @param string $tracking_id
	 * @throws \Exception
     */
	private function setTrackingId($tracking_id)
	{
		if (!is_string($tracking_id)){
			$type = gettype($tracking_id);
			throw new \Exception("Param must be of type 'string', '$type' provided");
		}
		$this->_tracking_id = $tracking_id;
	}

	/**
	 * @param boolean|string $client_id
	 * @throws \Exception
     */
	private function setClientId($client_id)
	{
		if($client_id === true){
			$this->_client_id = $this->v4RandUUID();
			return;
		}
		if (!is_string($client_id)){
			$type = gettype($client_id);
			throw new \Exception("Param must be of type 'string', '$type' provided");
		}
		$this->_client_id = $client_id;
	}

	/**
	 * Resets class state to produce new Hit
     */
	private function resetState()
	{
		$this->_client_id = null;
		$this->_hit_type = null;
		$this->_ReturnHit = null;
		$this->_tracking_id = null;
	}

	/**
	 * Generate Random v4 UUID
	 *
	 * @return string
	 */
	private function v4RandUUID()
	{
		$data = openssl_random_pseudo_bytes(16);
		assert(strlen($data) == 16);
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}
	
}