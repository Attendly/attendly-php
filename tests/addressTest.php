<?php

class addressCreateTest extends attendlyTest
{
    public function testCreateAddressFromEvent()
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

	public function testAddressDelete()
    {
        // Create an address
        $result = $this->attendly->address_create($this->address);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the id
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->address_get($id);

        $this->assertEquals($result2['Result']['Name'], $this->address['Name']);

        // Now delete
        $result3 = $this->attendly->address_delete($id);
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the address
        $result2 = $this->attendly->address_get($id);

        $this->assertEquals($result2['HTTP_status'], 400);
    }

    public function testAddressDeleteInvalidEvent()
    {
        $result = $this->attendly->address_delete(0);
        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');
    }

	public function testAddressGet()
    {
        // Create an address
        $result = $this->attendly->address_create($this->address);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the id
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->address_get($id);

        $this->assertEquals($result2['Result']['Name'], $this->address['Name']);
    }

    public function testAddressGetInvalidEvent()
    {
        $result = $this->attendly->address_get(0);
        $this->assertEquals($result['HTTP_status'], 404);
        $this->assertEquals($result['Status'], 'error');
    }

	public function testAddressUpdate()
    {
        // Create an address
        $result = $this->attendly->address_create($this->address);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the address
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->address_get($id);

        // Change the name
        $result2['Result']['Name'] = 'Address updated';
        $result3 = $this->attendly->address_update($result2['Result']);
        $this->assertEquals($result3['HTTP_status'], 204);
    }

	public function testEventUpdateNoId()
    {
        // Create an address
        $result = $this->attendly->address_create($this->address);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the address
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->address_get($id);

        // Change the name
        $result2['Result']['Name'] = 'Address updated';
		unset($result2['Result']['Id']);
        $result3 = $this->attendly->address_update($result2['Result']);
        $this->assertEquals($result3['Status'], 'error');
	}

    public function testAddressUpdateInvalid()
    {
    }


}
