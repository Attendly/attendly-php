<?php

class eventListTest extends AttendlyTest
{
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
