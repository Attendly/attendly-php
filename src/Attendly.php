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
	public $username = '';
	public $server = 'https://attendly.me/api/v4/';
	private $payload = array();


	public function __construct($username='', $apikey='')
	{
		$this->username = $username;
		$this->apikey = $apikey;
	}

	public function add_event(array $event)
	{
		$this->payload['Event'] = $event;
		return $this;
	}
	
	public function add_address(array $address)
	{
		$this->payload['Address'] = $address;
		return $this;
	}

	public function add_widget(array $widget)
	{
		// Check to see if Widgets is created
		if ( ! isset($this->payload['Widgets']))
		{
			$this->payload['Widgets'] = array();
		}

		$this->payload['Widgets'][] = $widget;
		return $this;
	}

	public function add_ticket(array $ticket)
	{
		// Check to see if Tickets is created
		if ( ! isset($this->payload['Tickets']))
		{
			$this->payload['Tickets'] = array();
		}

		$this->payload['Tickets'][] = $ticket;
		return $this;
	}
	
	public function add_ticket_limit($ticket_total)
	{
		// Check to see if Ticketspool is created
		if ( ! isset($this->payload['Ticketspool']))
		{
			$this->payload['Ticketspool'] = array();
		}

		$this->payload['Ticketspool']['Total'] = $ticket_total;
		return $this;
	}

	public function event_create()
	{
		return $this->request('event/create');
	}

	public function event_get($id)
	{
		return $this->request('event/get/'.$id);
	}
    
	private function request($method, $params=FALSE, $id=FALSE)
	{
		if ( ! $id)
		{
			$id = time();
		}

		$url = $this->server .= '/'.$method;

		$json_payload = json_encode($this->payload);

		// Send the payload and wait for a response
		$ch = curl_init();

		// Set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
		curl_setopt($ch, CURLOPT_USERPWD, $this->username.':'.$this->apikey);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FILETIME, TRUE);

		// Grab URL, and print
		$response = curl_exec($ch);
		$HTTP_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if (curl_errno($ch) > 0)
		{
			print_r(curl_error($ch), TRUE);
		}

		curl_close($ch);

		$decoded = json_decode($response, TRUE);

		return $decoded;
	}
}
