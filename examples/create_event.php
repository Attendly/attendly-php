<?php
require_once(__DIR__.'/../src/Attendly.php');

$attendly = new Attendly('testuser', '8de323378f4427ec9b38');

// Create an event
$event = array(
    'Name' => 'Test event via API',
    'Description'=> '<p>This is just a test event. Note <strong>HTML</strong>strong></p>p>',
    'Deadline'=> '2015-11-07T23:00:00Z',
    'Start'=> '2015-11-10T23:00:00Z',
    'Stop'=> '2015-11-10T23:00:00Z',
    'Status'=> 'active'
);

$ticket_1 = array(
    'Name' => 'Test ticket number one',
    'Description' => 'General',
    'Price' => 0,
    'Total' => 1000,
    'Order' => 1,
    'Status' => 'active'
);

$ticket_2 = array(
    'Name' => 'Test ticket number two',
    'Description' => 'General',
    'Price' => 0,
    'Total' => 1000,
    'Order' => 2,
    'Status' => 'active'
);

$text_widget = array(
    'Name' => 'Test widget one',
    'Description' => 'Just a widget',
    'Label' => 'A test label',
    'Order' => 1,
    'Type' => 'text',
    'Status' => 'active'
);

$textarea_widget = array(
    'Name' => 'Test widget two',
    'Description' => 'General',
    'label' => 'A test textarea',
    'Order' => 2,
    'Type' => 'textarea',
    'Status' => 'active'
);

$address = array(
    'Name' => 'Test address',
    'Line1' => '60 Something Road',
    'City' => 'Muckleford',
    'Post' => '3450',
    'State' => 'VICTORIA',
    'Country' => 'Australia',
    'Status' => 'active'
);

$result = $attendly
    ->add_event($event)
    ->add_ticket($ticket_1)
    ->add_ticket($ticket_2)
    ->add_ticket_limit(2000)
    ->add_widget($text_widget)
    ->add_widget($textarea_widget)
    ->add_address($address)
    ->event_create();


var_dump($result);
