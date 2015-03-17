<?php

if (! function_exists('curl_init')) {
    throw new Exception('Attendly needs some CURLing.');
}

if (! function_exists('json_decode')) {
    throw new Exception('Attendly needs its JSON.');
}

class Attendly
{
    public $apikey = '';
    public $username = '';
    public $server = 'https://attendly.me/api/v4/';
    private $payload = array();

    public function __construct($username = '', $apikey = '')
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
        if (! isset($this->payload['Widgets'])) {
            $this->payload['Widgets'] = array();
        }

        $this->payload['Widgets'][] = $widget;

        return $this;
    }

    public function add_ticket(array $ticket)
    {
        // Check to see if Tickets is created
        if (! isset($this->payload['Tickets'])) {
            $this->payload['Tickets'] = array();
        }

        $this->payload['Tickets'][] = $ticket;

        return $this;
    }

    public function add_ticket_limit($ticket_total)
    {
        // Check to see if Ticketspool is created
        if (! isset($this->payload['Ticketspool'])) {
            $this->payload['Ticketspool'] = array();
        }

        $this->payload['Ticketspool']['Total'] = $ticket_total;

        return $this;
    }

    public function event_create()
    {
        return $this->post('event/create');
    }

    public function event_get($id)
    {
        return $this->get('event/get/'.$id);
    }

    public function event_update(array $event)
    {
        // Need to make sure the event array has an id
        if (empty($event['Id'])) {
            return $this->error('You need to provide an Id to update an event');
        }

        $this->payload['Event'] = $event;

        return $this->put('event/update/'.$event['Id']);
    }

    public function event_delete($id)
    {
        return $this->delete('event/delete/'.$id);
    }

    public function address_create(array $address)
    {
        $this->payload['Address'] = $address;

        return $this->post('address/create');
    }

    public function event_list($type = '')
    {
        return $this->get('event/list/'.$type);
    }

    // Helpers
    private function error($message)
    {
        return array('Status' => 'error', 'Message' => $message);
    }

    private function get($path)
    {
        return $this->request($path, 'GET');
    }

    private function put($path)
    {
        return $this->request($path, 'PUT');
    }

    private function post($path)
    {
        return $this->request($path, 'POST');
    }

    private function delete($path)
    {
        return $this->request($path, 'DELETE');
    }

    private function request($path, $method = 'GET', $id = false)
    {
        if (! $id) {
            $id = time();
        }

        $url = $this->server.'/'.$path;

        $json_payload = json_encode($this->payload);

        // Send the payload and wait for a response
        $ch = curl_init();

        // Set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
                break;
            case 'GET':
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
        }

        curl_setopt($ch, CURLOPT_USERPWD, $this->username.':'.$this->apikey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FILETIME, true);

        // Grab URL, and print
        $response = curl_exec($ch);
        $HTTP_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch) > 0) {
            print_r(curl_error($ch), true);
        }

        curl_close($ch);

        $decoded = json_decode($response, true);

        $decoded['HTTP_status'] = $HTTP_status;

        return $decoded;
    }
}
