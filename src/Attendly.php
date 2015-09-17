<?php

/**
 * Attendly API.
 *
 * @Version: 2.4.0
 *
 * Library for accessing the Attendly api.
 *
 * @author Andrew Edwards <andrew@attendly.com>
 */

// Check we have curl
if (! function_exists('curl_init')) {
    throw new Exception('Attendly needs CURL.');
}

// Check we have json
if (! function_exists('json_decode')) {
    throw new Exception('Attendly needs JSON.');
}

class Attendly
{
    const VERSION = '2.4.0';
    const ERROR_NO_ID = 'You need to provide an ID';

    public $apikey = '';
    public $username = '';
    public $server = 'https://api.attendly.net/v2';
    private $payload = array();

    /**
     * Class constructor.
     *
     * @param string $username Attendly username
     * @param string $apikey   Attendly apikey (get it from the Attendly settings)
     */
    public function __construct($username = '', $apikey = '')
    {
        $this->username = $username;
        $this->apikey = $apikey;
    }

    /**
     * Creates an event.
     *
     * @return array Response from api
     */
    public function event_create($event = '')
    {
        // The event data may have been set via 'add_event', but if not it can
        // be pushed through as a param
        if (is_array($event) and ! empty($event)) {
            $this->payload['Event'] = $event;
        }

        return $this->post('event/create');
    }

    /**
     * Gets an event.
     *
     * @param int $id The event id
     *
     * @return array Response from api
     */
    public function event_get($id)
    {
        return $this->get('event/'.$id);
    }

    /**
     * Gets an events tickets.
     *
     * @param int $id The event id
     *
     * @return array Response from api
     */
    public function event_tickets($id)
    {
        return $this->get('event/'.$id.'/tickets');
	}

    /**
     * Gets an events teams.
     *
     * @param int $id The event id
     *
     * @return array Response from api
     */
    public function event_teams($id)
    {
        return $this->get('event/'.$id.'/teams');
	}

    /**
     * Update an event.
     *
     * @param array $event The address object
     *
     * @return array Response from api
     */
    public function event_update(array $event)
	{
        // Need to make sure the event array has an id
		if (empty($event['ID'])) {
            return $this->error(self::ERROR_NO_ID);
        }

        $this->payload['Event'] = $event;

        return $this->put('event/'.$event['ID']);
    }

    /**
     * Delete an event.
     *
     * @param int $id The event id
     *
     * @return array Response from api
     */
    public function event_delete($id)
    {
        return $this->delete('event/'.$id);
    }

    /**
     * Returns a list of events. You can specify the type of events you want
     * returned. Options are:.
     *
     *     active     All the active events (even expired ones)
     *     available  All the active and available events (not expired).
     *
     * The default ("") is to return all events includiing draft events.
     *
     * @param string $type The type of list to return
     *
     * @return array Response from api
     */
    public function event_list($type = '', $id= '')
	{
        // Need to make sure the ID exists for group lists
		if ($type === 'group' AND empty($id)) {
            return $this->error(self::ERROR_NO_ID);
		}

		if ($type === 'group')
		{
			$type = 'group/'.$id;
		}
        return $this->get('events/'.$type);
    }

    /**
     * Creates an address.
     *
     * @return array Response from api
     */
    public function address_create(array $address)
    {
        $this->payload['Address'] = $address;

        return $this->post('address');
    }

    /**
     * Get an address.
     *
     * @param int $id The address id
     *
     * @return array Response from api
     */
    public function address_get($id)
    {
        return $this->get('address/'.$id);
    }

    /**
     * Update an address.
     *
     * @param array $address The address object
     *
     * @return array Response from api
     */
    public function address_update(array $address)
    {
        // Need to make sure the address array has an id
        if (empty($address['ID'])) {
            return $this->error(self::ERROR_NO_ID);
        }

        $this->payload['Address'] = $address;

        return $this->put('address/'.$address['ID']);
    }

    /**
     * Delete an address.
     *
     * @param int $id The address id
     *
     * @return array Response from api
     */
    public function address_delete($id)
    {
        return $this->delete('address/'.$id);
    }

    /**
     * Get an group.
     *
     * @param int $id The group id
     *
     * @return array Response from api
     */
    public function group_get($id)
    {
        return $this->get('group/'.$id);
	}

    /**
     * Update an group.
     *
     * @param array $group The group object
     *
     * @return array Response from api
     */
    public function group_update(array $group)
	{
        // Need to make sure the group array has an id
		if (empty($group['ID'])) {
            return $this->error(self::ERROR_NO_ID);
        }

        $this->payload['Group'] = $group;

        return $this->put('group/'.$group['ID']);
	}

    /**
     * Returns a list of groups
     *
     * @return array Response from api
     */
    public function group_list()
    {
        return $this->get('groups');
	}

    /**
     * Creates an ticket.
     *
     * @return array Response from api
     */
    public function ticket_create(array $ticket)
    {
        $this->payload['Ticket'] = $ticket;

        return $this->post('ticket');
    }

    /**
     * Get an ticket.
     *
     * @param int $id The ticket id
     *
     * @return array Response from api
     */
    public function ticket_get($id)
    {
        return $this->get('ticket/'.$id);
    }

    /**
     * Update an ticket.
     *
     * @param array $ticket The ticket object
     *
     * @return array Response from api
     */
    public function ticket_update(array $ticket)
    {
        // Need to make sure the ticket array has an id
        if (empty($ticket['ID'])) {
            return $this->error(self::ERROR_NO_ID);
        }

        $this->payload['Ticket'] = $ticket;

        return $this->put('ticket/'.$ticket['ID']);
    }

    /**
     * Delete an ticket.
     *
     * @param int $id The ticket id
     *
     * @return array Response from api
     */
    public function ticket_delete($id)
    {
        return $this->delete('ticket/'.$id);
    }

    /**
     * Creates an widget.
     *
     * @return array Response from api
     */
    public function widget_create(array $widget)
    {
        $this->payload['Widget'] = $widget;

        return $this->post('widget');
    }

    /**
     * Get an widget.
     *
     * @param int $id The widget id
     *
     * @return array Response from api
     */
    public function widget_get($id)
    {
        return $this->get('widget/'.$id);
    }

    /**
     * Update an widget.
     *
     * @param array $widget The widget object
     *
     * @return array Response from api
     */
    public function widget_update(array $widget)
    {
        // Need to make sure the widget array has an id
        if (empty($widget['ID'])) {
            return $this->error(self::ERROR_NO_ID);
        }

        $this->payload['Widget'] = $widget;

        return $this->put('widget/'.$widget['ID']);
    }

    /**
     * Delete an widget.
     *
     * @param int $id The widget id
     *
     * @return array Response from api
     */
    public function widget_delete($id)
    {
        return $this->delete('widget/'.$id);
    }

    /**
     * Creates an theme.
     *
     * @return array Response from api
     */
    public function theme_create(array $theme)
    {
        $this->payload['Theme'] = $theme;

        return $this->post('theme');
    }

    /**
     * Get an theme.
     *
     * @param int $id The theme id
     *
     * @return array Response from api
     */
    public function theme_get($id)
    {
        return $this->get('theme/'.$id);
    }

    /**
     * Update an theme.
     *
     * @param array $theme The theme object
     *
     * @return array Response from api
     */
    public function theme_update(array $theme)
    {
        // Need to make sure the theme array has an id
        if (empty($theme['ID'])) {
            return $this->error(self::ERROR_NO_ID);
        }

        $this->payload['Theme'] = $theme;

        return $this->put('theme/'.$theme['ID']);
    }

    /**
     * Creates an ticketspool.
     *
     * @return array Response from api
     */
    public function ticketspool_create(array $ticketspool)
    {
        $this->payload['Ticketspool'] = $ticketspool;

        return $this->post('ticketspool');
    }

    /**
     * Get an ticketspool.
     *
     * @param int $id The ticketspool id
     *
     * @return array Response from api
     */
    public function ticketspool_get($id)
    {
        return $this->get('ticketspool/'.$id);
    }

    /**
     * Update an ticketspool.
     *
     * @param array $ticketspool The ticketspool object
     *
     * @return array Response from api
     */
    public function ticketspool_update(array $ticketspool)
    {
        // Need to make sure the ticketspool array has an id
        if (empty($ticketspool['ID'])) {
            return $this->error(self::ERROR_NO_ID);
        }

        $this->payload['Ticketspool'] = $ticketspool;

        return $this->put('ticketspool/'.$ticketspool['ID']);
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

        // @codeCoverageIgnoreStart
        if (curl_errno($ch) > 0) {
            print_r(curl_error($ch), true);
        }
        // @codeCoverageIgnoreEnd

        curl_close($ch);

        $decoded = json_decode($response, true);

        $decoded['HTTP_status'] = $HTTP_status;

        return $decoded;
    }
}
