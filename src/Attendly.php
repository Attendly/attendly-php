<?php

/**
 * Attendly API.
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
    const VERSION = 2.1;
    const ERROR_NO_ID = 'You need to provide an Id';

    public $apikey = '';
    public $username = '';
    public $server = 'https://attendly.me/api/v4/';
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

    public function add_theme(array $theme)
    {
        $this->payload['Theme'] = $theme;

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
        return $this->get('event/get/'.$id);
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
        if (empty($event['Id'])) {
            return $this->error(ERROR_NO_ID);
        }

        $this->payload['Event'] = $event;

        return $this->put('event/update/'.$event['Id']);
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
        return $this->delete('event/delete/'.$id);
    }

    /**
     * Returns a list of events. You can specify the type of events you want
     * returned. Options are:
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
    public function event_list($type = '')
    {
        return $this->get('event/list/'.$type);
    }

    /**
     * Creates an address.
     *
     * @return array Response from api
     */
    public function address_create(array $address)
    {
        $this->payload['Address'] = $address;

        return $this->post('address/create');
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
        return $this->get('address/get/'.$id);
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
        if (empty($address['Id'])) {
            return $this->error(ERROR_NO_ID);
        }

        $this->payload['Address'] = $address;

        return $this->put('address/update/'.$address['Id']);
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
        return $this->delete('address/delete/'.$id);
    }

    /**
     * Creates an ticket.
     *
     * @return array Response from api
     */
    public function ticket_create(array $ticket)
    {
        $this->payload['Ticket'] = $ticket;

        return $this->post('ticket/create');
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
        return $this->get('ticket/get/'.$id);
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
        if (empty($ticket['Id'])) {
            return $this->error(ERROR_NO_ID);
        }

        $this->payload['Ticket'] = $ticket;

        return $this->put('ticket/update/'.$ticket['Id']);
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
        return $this->delete('ticket/delete/'.$id);
    }

    /**
     * Creates an widget.
     *
     * @return array Response from api
     */
    public function widget_create(array $widget)
    {
        $this->payload['Widget'] = $widget;

        return $this->post('widget/create');
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
        return $this->get('widget/get/'.$id);
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
        if (empty($widget['Id'])) {
            return $this->error(ERROR_NO_ID);
        }

        $this->payload['Widget'] = $widget;

        return $this->put('widget/update/'.$widget['Id']);
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
        return $this->delete('widget/delete/'.$id);
    }

    /**
     * Creates an fieldset.
     *
     * @return array Response from api
     */
    public function fieldset_create(array $fieldset)
    {
        $this->payload['Fieldset'] = $fieldset;

        return $this->post('fieldset/create');
    }

    /**
     * Get an fieldset.
     *
     * @param int $id The fieldset id
     *
     * @return array Response from api
     */
    public function fieldset_get($id)
    {
        return $this->get('fieldset/get/'.$id);
    }

    /**
     * Update an fieldset.
     *
     * @param array $fieldset The fieldset object
     *
     * @return array Response from api
     */
    public function fieldset_update(array $fieldset)
    {
        // Need to make sure the fieldset array has an id
        if (empty($fieldset['Id'])) {
            return $this->error(ERROR_NO_ID);
        }

        $this->payload['Fieldset'] = $fieldset;

        return $this->put('fieldset/update/'.$fieldset['Id']);
    }

    /**
     * Delete an fieldset.
     *
     * @param int $id The fieldset id
     *
     * @return array Response from api
     */
    public function fieldset_delete($id)
    {
        return $this->delete('fieldset/delete/'.$id);
    }

    /**
     * Creates an theme.
     *
     * @return array Response from api
     */
    public function theme_create(array $theme)
    {
        $this->payload['Theme'] = $theme;

        return $this->post('theme/create');
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
        return $this->get('theme/get/'.$id);
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
        if (empty($theme['Id'])) {
            return $this->error(ERROR_NO_ID);
        }

        $this->payload['Theme'] = $theme;

        return $this->put('theme/update/'.$theme['Id']);
    }

    /**
     * Delete an theme.
     *
     * @param int $id The theme id
     *
     * @return array Response from api
     */
    public function theme_delete($id)
    {
        return $this->delete('theme/delete/'.$id);
    }

    /**
     * Creates an ticketspool.
     *
     * @return array Response from api
     */
    public function ticketspool_create(array $ticketspool)
    {
        $this->payload['Ticketspool'] = $ticketspool;

        return $this->post('ticketspool/create');
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
        return $this->get('ticketspool/get/'.$id);
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
        if (empty($ticketspool['Id'])) {
            return $this->error(ERROR_NO_ID);
        }

        $this->payload['Ticketspool'] = $ticketspool;

        return $this->put('ticketspool/update/'.$ticketspool['Id']);
    }

    /**
     * Delete an ticketspool.
     *
     * @param int $id The ticketspool id
     *
     * @return array Response from api
     */
    public function ticketspool_delete($id)
    {
        return $this->delete('ticketspool/delete/'.$id);
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
