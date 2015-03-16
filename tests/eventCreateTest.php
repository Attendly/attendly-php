<?php

class EventCreateTest extends PHPUnit_Framework_TestCase
{
	public $attendly;
	private $test_user = 'testuser';
	private $test_apikey = '8de323378f4427ec9b38';
	
	private $event = array(
		'Name' => 'Test event via API',
		'Description'=> '<p>This is a test event. Note <strong>HTML</strong>strong></p>p>',
		'Deadline'=> '2017-11-07T23:00:00Z',
		'Start'=> '2017-11-10T23:00:00Z',
		'Stop'=> '2017-11-10T23:00:00Z',
		'Status'=> 'active'
	);

	private $ticket_1 = array(
		'Name' => 'Test ticket number one',
		'Description' => 'General',
		'Price' => 0,
		'Total' => 1000,
		'Order' => 1,
		'Status' => 'active'
	);

	private $ticket_2 = array(
		'Name' => 'Test ticket number two',
		'Description' => 'General',
		'Price' => 0,
		'Total' => 1000,
		'Order' => 2,
		'Status' => 'active'
	);

	private $text_widget = array(
		'Name' => 'Test widget one',
		'Description' => 'Just a widget',
		'Label' => 'A test label',
		'Order' => 1,
		'Type' => 'text',
		'Status' => 'active'
	);

	private	$textarea_widget = array(
		'Name' => 'Test widget two',
		'Description' => 'General',
		'label' => 'A test textarea',
		'Order' => 2,
		'Type' => 'textarea',
		'Status' => 'active'
	);

	private $address = array(
		'Name' => 'Test address',
		'Line1' => '60 Something Road',
		'City' => 'Muckleford South',
		'Post' => '3450',
		'State' => 'VICTORIA',
		'Country' => 'Australia',
		'Status' => 'active'
	);

	public function setup()
	{
		$this->attendly = new Attendly($this->test_user, $this->test_apikey);
		$this->attendly->server = 'http://localhost:3000/v2';
	}

	public function testCreateEvent()
	{
		// Create an event
		$result = $this->attendly
			->add_event($this->event)
			->add_ticket($this->ticket_1)
			->add_ticket($this->ticket_2)
			->add_ticket_limit(2000)
			->add_widget($this->text_widget)
			->add_widget($this->textarea_widget)
			->add_address($this->address)
			->event_create();

		$this->assertEquals($result['Status'], 'ok');
		$this->assertEquals($result['HTTP_status'], 201);
		$this->assertEquals($result['Result']['Name'], $this->event['Name']);
	}

	public function testDodgyEvent()
	{
		// Create a dodgy event (no event details)
		$result = $this->attendly
			//->add_event($event)
			->add_ticket($this->ticket_1)
			->add_ticket($this->ticket_2)
			->add_ticket_limit(2000)
			->add_widget($this->text_widget)
			->add_widget($this->textarea_widget)
			->add_address($this->address)
			->event_create();

		$this->assertEquals($result['HTTP_status'], 400);
		$this->assertEquals($result['Status'], 'error');
	}

	public function testMinimalEvent()
	{
		// Create an event without widgets or tickets
		$result = $this->attendly
			->add_event($this->event)
			->event_create();

		$this->assertEquals($result['Status'], 'ok');
		$this->assertEquals($result['HTTP_status'], 201);
		$this->assertEquals($result['Result']['Name'], $this->event['Name']);
	}

}
