<?php

class addressCreateTest extends AttendlyTest
{
    public function testEventCreateAddress()
    {
        // Create an event
        $result = $this->attendly
            ->add_event($this->event)
            ->add_address($this->address)
            ->event_create();

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);
        $this->assertEquals($result['Result']['Name'], $this->event['Name']);
    }

    public function testCreateAddress()
    {
        // Create an address
        $result = $this->attendly->address_create($this->address);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);
    }

    public function testDodgyAddress()
    {
        // Create a dodgy address
        $this->address['Status'] = 'dsfdsfsdfdsf';
        $result = $this->attendly->address_create($this->address);

        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');

        $this->address['Status'] = 'active';
        $this->address['Line1'] = 'this is a really long line. this is a really long line. this is a really long line. this is a really long line. this is a really long line. ';
        $result = $this->attendly->address_create($this->address);

        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');
    }
}
