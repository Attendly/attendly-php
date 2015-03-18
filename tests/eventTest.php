<?php

class eventTest extends attendlyTest
{
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

    public function testCreateEventData()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);

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

    public function testEventDelete()
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

        $this->assertEquals($result2['Result']['Name'], $this->event['Name']);

        // Now delete
        $result3 = $this->attendly->event_delete($id);
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the event
        $result2 = $this->attendly->event_get($id);

        $this->assertEquals($result2['HTTP_status'], 400);
    }

    public function testEventDeleteInvalidEvent()
    {
        $result = $this->attendly->event_delete(0);
        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');
    }

    public function testEventGet()
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

        $this->assertEquals($result2['Result']['Name'], $this->event['Name']);
    }

    public function testEventGetInvalidEvent()
    {
        $result = $this->attendly->event_get(0);
        $this->assertEquals($result['HTTP_status'], 500);
        $this->assertEquals($result['Status'], 'error');
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

    public function testEventUpdateNoId()
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
        unset($result2['Result']['Id']);
        $result3 = $this->attendly->event_update($result2['Result']);
        $this->assertEquals($result3['Status'], 'error');
    }

    public function testEventUpdateInvalidEvent()
    {
        $result = $this->attendly->event_get(0);
        $this->assertEquals($result['Status'], 'error');
    }
}
