<?php

class eventUpdateTest extends AttendlyTest
{
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
