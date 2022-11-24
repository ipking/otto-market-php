<?php

namespace OttoMarket\Api;

use OttoMarket\Core\Client;

class Token extends Client {

	/**
	* Operation getToken
	 * @param array $body
	*/
	public function getToken($body = [])
	{
		return $this->send("/v1/token", [
		  'method' => 'POST',
		  'form'   => $body,
		]);
	}
}
