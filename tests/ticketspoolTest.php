<?php

class ticketspoolCreateTest extends attendlyTest
{
    public function testCreateTicketspool()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['Status'], 'ok');

		$this->ticketspool['EventId'] = $result['Result']['Id'];
		
        // Create an ticketspool
        $result = $this->attendly->ticketspool_create($this->ticketspool);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);
    }

    public function testDodgyTicketspool()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['Status'], 'ok');

		$this->ticketspool['EventId'] = $result['Result']['Id'];
        // Create a dodgy ticketspool
        $this->ticketspool['Total'] = 'dsfdsfsdfdsf';
        $result = $this->attendly->ticketspool_create($this->ticketspool);

        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');

        $this->ticketspool['Total'] = 'active';
        $this->ticketspool['ShowFees'] = 'this is a really long line. this is a really long line. this is a really long line. this is a really long line. this is a really long line. ';
        $result = $this->attendly->ticketspool_create($this->ticketspool);

        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');
	}

	public function testTicketspoolGet()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['Status'], 'ok');

		$this->ticketspool['EventId'] = $result['Result']['Id'];
        $result = $this->attendly->ticketspool_create($this->ticketspool);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the id
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->ticketspool_get($id);

        $this->assertEquals($result2['Result']['Total'], $this->ticketspool['Total']);
    }

    public function testTicketspoolGetInvalidEvent()
    {
        $result = $this->attendly->ticketspool_get(0);
        $this->assertEquals($result['HTTP_status'], 500);
        $this->assertEquals($result['Status'], 'error');
    }

	public function testTicketspoolUpdate()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['Status'], 'ok');

		$this->ticketspool['EventId'] = $result['Result']['Id'];

        // Create an ticketspool
        $result = $this->attendly->ticketspool_create($this->ticketspool);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the ticketspool
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->ticketspool_get($id);

        // Change the name
        $result2['Result']['Name'] = 'Ticketspool updated';
        $result3 = $this->attendly->ticketspool_update($result2['Result']);
        $this->assertEquals($result3['HTTP_status'], 204);
	}

	public function testTicketspoolUpdateNoId()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['Status'], 'ok');

		$this->ticketspool['EventId'] = $result['Result']['Id'];

        // Create an ticketspool
        $result = $this->attendly->ticketspool_create($this->ticketspool);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the ticketspool
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->ticketspool_get($id);

        // Change the name
        $result2['Result']['Name'] = 'Ticketspool updated';
		unset($result2['Result']['Id']);
        $result3 = $this->attendly->ticketspool_update($result2['Result']);
        $this->assertEquals($result3['Status'], 'error');
    }

}
