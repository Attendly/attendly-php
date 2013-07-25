<?php

if ( ! function_exists('curl_init'))
{
	throw new Exception('Attendly needs some CURLing.');
}

if ( ! function_exists('json_decode'))
{
 	throw new Exception('Attendly needs its JSON.');
}

class Attendly {

	public $apikey = '';
	private $url = 'https://attendly.me/api/v4/';

	public function __construct($apikey='')
	{
		$this->apikey = $apikey;
	}

	public function user_login($name, $password)
	{
		$params = array('user'=>array('name'=>$name,'password'=>$password));
		return $this->request('user.login', $params);
	}

	public function event_list()
	{
		$params = array();
		return $this->request('event.list', $params);
	}

	public function event_get($id)
	{
		$params = array('event'=>array('id'=>$id));
		return $this->request('event.get', $params);
	}

	private function request($method, $params, $id=FALSE)
	{
		if ( ! $id)
		{
			$id = time();
		}

		$payload = array(
			'jsonrpc' => '2.0',
			'method' => $method,
			'id' => time(),
			'params' => $params);

		$json_payload = json_encode($payload);

		// Send the payload and wait for a response
		$ch = curl_init();

		// Set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
		curl_setopt($ch, CURLOPT_USERPWD, $this->apikey.':');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FILETIME, TRUE);

		// Grab URL, and print
		$response = curl_exec($ch);

		if (curl_errno($ch) > 0)
		{
			print_r(curl_error($ch), TRUE);
		}

		curl_close($ch);

		$decoded = json_decode($response, TRUE);

		if (isset($decoded['result']))
		{
			return $decoded['result'];
		}
		else
		{
			return FALSE;
		}
	}
}