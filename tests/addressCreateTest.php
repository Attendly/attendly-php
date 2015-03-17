<?php

class AddressCreateTest extends AttendlyTest
{

	public function testCreateAddress()
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

	public function testDodgyAddress()
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

	public function testMinimalAddress()
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
