<?php

class themeTest extends AttendlyTest
{
    public function testThemeGet()
    {
        $result = $this->attendly
            ->add_event($this->event)
			->add_theme($this->theme)
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
}
