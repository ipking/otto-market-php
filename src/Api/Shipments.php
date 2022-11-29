<?php

namespace OttoMarket\Api;

use OttoMarket\Core\Client;

class Shipments extends Client {

	/**
	* Operation createShipments
	 * @param array $body
	*/
	public function createShipments($body = [])
	{
		return $this->send("/v1/shipments", [
		  'method' => 'POST',
		  'json'   => $body,
		]);
	}
	
	/**
	 * Operation correctShipments
	 * @param string $carrier
	 * @param string $trackingNumber
	 * @param array $body
	 */
	public function correctShipments($carrier,$trackingNumber,$body = [])
	{
		return $this->send("/v1/shipments/carriers/'.$carrier.'/trackingnumbers/'.$trackingNumber.'/positionitems", [
			'method' => 'POST',
			'json'   => $body,
		]);
	}
}
