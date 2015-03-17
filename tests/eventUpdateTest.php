<?php

class EventUpdateTest extends PHPUnit_Framework_TestCase
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

	public function setup()
	{
		$this->attendly = new Attendly($this->test_user, $this->test_apikey);
		$this->attendly->server = 'https://testapi.attendly.net/v2';
	}

	public function testEventUpdate()
	{
		$result = $this->attendly
			->add_event($this->event)
			->event_create();

		$this->assertEquals($result['Status'], 'ok');
		$this->assertEquals($result['HTTP_status'], 201);
		$this->assertEquals($result['Result']['Name'], $this->event['Name']);

        // Now get the event
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->event_get($id);

        // Change the name
        $result2['Result']['Name'] = 'Event updated';
        $result3 = $this->attendly->event_update($result2['Result']);
		$this->assertEquals($result3['HTTP_status'], 204);

	}

	public function testEventUpdateInvalidEvent()
	{
        $result = $this->attendly->event_get(0);
		$this->assertEquals($result['Status'], 'error');
	}
}
