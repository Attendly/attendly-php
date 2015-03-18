<?php

class widgetCreateTest extends attendlyTest
{
    public function testCreateWidgetFromEvent()
    {
        // Create an event
        $result = $this->attendly
            ->add_event($this->event)
            ->add_widget($this->text_widget)
            ->event_create();

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);
        $this->assertEquals($result['Result']['Name'], $this->event['Name']);
    }

    public function testCreateWidget()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['HTTP_status'], 201);

        // Create an widget
		$this->text_widget['EventId'] = $result['Result']['Id'];

        $result = $this->attendly->widget_create($this->text_widget);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);
    }

    public function testDodgyWidget()
    {
        // Create a dodgy widget
        $this->text_widget['Status'] = 'dsfdsfsdfdsf';
        $result = $this->attendly->widget_create($this->text_widget);

        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');

        $this->text_widget['Status'] = 'active';
        $this->text_widget['Line1'] = 'this is a really long line. this is a really long line. this is a really long line. this is a really long line. this is a really long line. ';
        $result = $this->attendly->widget_create($this->text_widget);

        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');
	}

	public function testWidgetDelete()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['HTTP_status'], 201);

        // Create an widget
		$this->text_widget['EventId'] = $result['Result']['Id'];
        $result = $this->attendly->widget_create($this->text_widget);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the id
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->widget_get($id);

        $this->assertEquals($result2['Result']['Label'], $this->text_widget['Label']);

        // Now delete
        $result3 = $this->attendly->widget_delete($id);
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the widget
        $result2 = $this->attendly->widget_get($id);

        $this->assertEquals($result2['HTTP_status'], 400);
    }

    public function testWidgetDeleteInvalidEvent()
    {
        $result = $this->attendly->widget_delete(0);
        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');
    }

	public function testWidgetGet()
    {
        // Create an event
        $result = $this->attendly->event_create($this->event);
        $this->assertEquals($result['HTTP_status'], 201);

        // Create an widget
		$this->text_widget['EventId'] = $result['Result']['Id'];
        $result = $this->attendly->widget_create($this->text_widget);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the id
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->widget_get($id);

        $this->assertEquals($result2['Result']['Label'], $this->text_widget['Label']);
    }

    public function testWidgetGetInvalid()
    {
        $result = $this->attendly->widget_get(0);
        $this->assertEquals($result['HTTP_status'], 500);
        $this->assertEquals($result['Status'], 'error');
    }

	public function testWidgetUpdate()
    {
        // Create an event
        $eresult = $this->attendly->event_create($this->event);
        $this->assertEquals($eresult['HTTP_status'], 201);

        // Create an widget
		$this->text_widget['EventId'] = $eresult['Result']['Id'];
        $result = $this->attendly->widget_create($this->text_widget);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the widget
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->widget_get($id);

        // Change the name
        $result2['Result']['Label'] = 'Widget updated';
        $result2['Result']['EventId'] = $eresult['Result']['Id'];

        $result3 = $this->attendly->widget_update($result2['Result']);
        $this->assertEquals($result3['HTTP_status'], 204);
    }

	public function testWidgetUpdateNoId()
    {
        // Create an event
        $eresult = $this->attendly->event_create($this->event);
        $this->assertEquals($eresult['HTTP_status'], 201);

        // Create an widget
		$this->text_widget['EventId'] = $eresult['Result']['Id'];
        $result = $this->attendly->widget_create($this->text_widget);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the widget
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->widget_get($id);

        // Change the name
        $result2['Result']['Label'] = 'Widget updated';
        $result2['Result']['EventId'] = $eresult['Result']['Id'];
		unset($result2['Result']['Id']);
        $result3 = $this->attendly->widget_update($result2['Result']);
        $this->assertEquals($result3['Status'], 'error');
	}

    public function testWidgetUpdateInvalid()
    {
    }


}
