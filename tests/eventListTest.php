<?php

class EventListTest extends PHPUnit_Framework_TestCase
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
		$this->attendly->server = 'http://localhost:3000/v2';
	}

	public function testEventList()
	{
		$result = $this->attendly
			->add_event($this->event)
			->event_create();

		$this->assertEquals($result['Status'], 'ok');
		$this->assertEquals($result['HTTP_status'], 201);
		$this->assertEquals($result['Result']['Name'], $this->event['Name']);

        // Now get the events
        $result2 = $this->attendly->event_list();
		$this->assertEquals($result2['HTTP_status'], 200);
		$this->assertGreaterThan(0, count($result2['Result']));
	}
}
