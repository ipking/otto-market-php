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
}
