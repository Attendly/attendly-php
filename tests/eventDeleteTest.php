<?php

class eventDeleteTest extends AttendlyTest
{
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
}
