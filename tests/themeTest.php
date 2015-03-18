<?php

class themeTest extends attendlyTest
{
    public function testCreateThemeFromEvent()
    {
        // Create an event
        $result = $this->attendly
            ->add_event($this->event)
            ->add_theme($this->theme)
            ->event_create();

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);
        $this->assertEquals($result['Result']['Name'], $this->event['Name']);
    }

    public function testCreateTheme()
    {
        // Create an theme
        $result = $this->attendly->theme_create($this->theme);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);
    }

    public function testDodgyTheme()
    {
        // Create a dodgy theme
        $this->theme['Status'] = 'dsfdsfsdfdsf';
        $result = $this->attendly->theme_create($this->theme);

        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');

        $this->theme['Status'] = 'active';
        $this->theme['HeaderTextRGB'] = 'this is a really long line. this is a really long line. this is a really long line. this is a really long line. this is a really long line. ';
        $result = $this->attendly->theme_create($this->theme);

        $this->assertEquals($result['HTTP_status'], 400);
        $this->assertEquals($result['Status'], 'error');
    }

    public function testThemeGet()
    {
        // Create an theme
        $result = $this->attendly->theme_create($this->theme);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the id
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->theme_get($id);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);
    }

    public function testThemeGetInvalidEvent()
    {
        $result = $this->attendly->theme_get(0);
        $this->assertEquals($result['HTTP_status'], 500);
        $this->assertEquals($result['Status'], 'error');
    }

    public function testThemeUpdate()
    {
        // Create an theme
        $result = $this->attendly->theme_create($this->theme);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the theme
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->theme_get($id);

        // Change a colour
        $result2['Result']['HeaderTextRGB'] = '00ff00';
        $result3 = $this->attendly->theme_update($result2['Result']);
        $this->assertEquals($result3['HTTP_status'], 204);

        // Now get the theme
        $result4 = $this->attendly->theme_get($id);
        $this->assertTrue($result4['Result']['HeaderTextRGB'] === '00ff00');
    }

    public function testThemeUpdateNoId()
    {
        // Create an theme
        $result = $this->attendly->theme_create($this->theme);

        $this->assertEquals($result['Status'], 'ok');
        $this->assertEquals($result['HTTP_status'], 201);

        // Now get the theme
        $id = $result['Result']['Id'];
        $this->assertTrue(is_numeric($id), 'Id needs to exist and be numeric');

        $result2 = $this->attendly->theme_get($id);

        // Change a colour
        $result2['Result']['HeaderTextRGB'] = '00ff00';
        unset($result2['Result']['Id']);
        $result3 = $this->attendly->theme_update($result2['Result']);
        $this->assertEquals($result3['Status'], 'error');
    }

    public function testThemeUpdateInvalid()
    {
    }
}
