<?php

require_once __DIR__.'/../src/Attendly.php';

class attendlyTest extends PHPUnit_Framework_TestCase
{
    public $attendly;

    public $event = array(
        'Name' => 'Test event via API',
        'Description' => '<p>This is a test event. Note <strong>HTML</strong>strong></p>',
        'Deadline' => '2017-11-07T23:00:00Z',
        'Start' => '2017-11-10T23:00:00Z',
        'Stop' => '2017-11-10T23:00:00Z',
        'Status' => 'active',
    );

    public $ticket_1 = array(
        'Name' => 'Test ticket number one',
        'Description' => 'General',
        'Price' => 0,
        'Total' => 1000,
        'Order' => 1,
        'Status' => 'active',
    );

    public $ticket_2 = array(
        'Name' => 'Test ticket number two',
        'Description' => 'General',
        'Price' => 0,
        'Total' => 1000,
        'Order' => 2,
        'Status' => 'active',
    );

    public $text_widget = array(
        'Name' => 'Test widget one',
        'Description' => 'Just a widget',
        'Label' => 'A test label',
        'Order' => 1,
        'Type' => 'text',
        'Status' => 'active',
    );

    public $textarea_widget = array(
        'Name' => 'Test widget two',
        'Description' => 'General',
        'label' => 'A test textarea',
        'Order' => 2,
        'Type' => 'textarea',
        'Status' => 'active',
    );

    public $address = array(
        'Name' => 'Test address',
        'Line1' => '60 Something Road',
        'City' => 'Muckleford South',
        'Post' => '3450',
        'State' => 'VICTORIA',
        'Country' => 'Australia',
        'Status' => 'active',
    );

	public $theme = array(
		'Name' => 'test',
		'PageBackgroundRGB' => 'cc0000',
		'HeaderBackgroundRGB' => 'cc0000',
		'HeaderTextRGB' => 'cc0000',
		'TextHeadingsRGB' => 'cc0000',
		'SmallHeadingRGB' => 'cc0000',
		'Status' => 'active'
	);

    public function setup()
    {
        $this->attendly = new Attendly(
            getenv('ATTENDLY_API_TEST_USER'),
            getenv('ATTENDLY_API_TEST_KEY'));
        $this->attendly->server = getenv('ATTENDLY_API_TEST_SERVER');
    }
}
