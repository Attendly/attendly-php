<?php

class ticketCreateTest extends attendlyTest
{
    public function testCreateTicketFromEvent()
    {
        // Create an event
        $result = $this->attendly
            ->add_event($this->event)
            ->add_ticket($this->ticket_1)
            ->event_create();

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);
        $this->assertEquals($result['Result']['Name'], $this->event['Name']);
    }

    public function testCreateTicket()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['HTTP_status'], 201);

        // Create an ticket
        $this->ticket_1['EventId'] = $result['Result']['Id'];

        $result = $this->attendly->ticket_create($this->ticket_1);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);
    }

    public function testDodgyTicket()
    {
        // Create a dodgy ticket
        $this->ticket_1['Status'] = 'dsfdsfsdfdsf';
        $result = $this->attendly->ticket_create($this->ticket_1);

        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');

        $this->ticket_1['Status'] = 'active';
        $this->ticket_1['Line1'] = 'this is a really long line. this is a really long line. this is a really long line. this is a really long line. this is a really long line. ';
        $result = $this->attendly->ticket_create($this->ticket_1);

        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');
    }

    public function testTicketDelete()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['HTTP_status'], 201);

        // Create an ticket
        $this->ticket_1['EventId'] = $result['Result']['Id'];
        $result = $this->attendly->ticket_create($this->ticket_1);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the id
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->ticket_get($id);

        $this->assertEquals($result2['Result']['Name'], $this->ticket_1['Name']);

        // Now delete
        $result3 = $this->attendly->ticket_delete($id);
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the ticket
        $result2 = $this->attendly->ticket_get($id);

        $this->assertEquals($result2['HTTP_status'], 400);
    }

    public function testTicketDeleteInvalidEvent()
    {
        $result = $this->attendly->ticket_delete(0);
        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');
    }

    public function testTicketGet()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['HTTP_status'], 201);

        // Create an ticket
        $this->ticket_1['EventId'] = $result['Result']['Id'];
        $result = $this->attendly->ticket_create($this->ticket_1);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the id
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->ticket_get($id);

        $this->assertEquals($result2['Result']['Name'], $this->ticket_1['Name']);
    }

    public function testTicketGetInvalid()
    {
        $result = $this->attendly->ticket_get(0);
        $this->assertEquals($result['HTTP_status'], 500);
        $this->assertEquals($result['Status'], 'error');
    }

    public function testTicketUpdate()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['HTTP_status'], 201);

        // Create an ticket
        $this->ticket_1['EventId'] = $result['Result']['Id'];
        $result = $this->attendly->ticket_create($this->ticket_1);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the ticket
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->ticket_get($id);

        // Change the name
        $result2['Result']['Name'] = 'Ticket updated';
        $result3 = $this->attendly->ticket_update($result2['Result']);
        $this->assertEquals($result3['HTTP_status'], 204);
    }

    public function testTicketUpdateNoId()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['HTTP_status'], 201);

        // Create an ticket
        $this->ticket_1['EventId'] = $result['Result']['Id'];
        $result = $this->attendly->ticket_create($this->ticket_1);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the ticket
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->ticket_get($id);

        // Change the name
        $result2['Result']['Name'] = 'Ticket updated';
        unset($result2['Result']['Id']);
        $result3 = $this->attendly->ticket_update($result2['Result']);
        $this->assertEquals($result3['Status'], 'error');
    }

    public function testTicketUpdateInvalid()
    {
    }
}
