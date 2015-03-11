<?php

class EventCreateTest extends PHPUnit_Framework_TestCase
{
	public $attendly;
	private $test_user = 'testuser';
	private $test_apikey = '8de323378f4427ec9b38';
	
	public function setup()
	{
		$this->attendly = new Attendly($this->test_user, $this->test_apikey);
		$this->attendly->server = 'http://localhost:3000';
	}

	public function testCreateEvent()
	{
		$a = new Attendly;
		$this->assertEquals("1","1");
	}


}
