<?php
require_once __DIR__.'/../src/Attendly.php';


// Get username and key from ENV variables, they could be hard coded or from a
// config file - etc.
$user = getenv('ATTENDLY_API_USER');
$key = getenv('ATTENDLY_API_KEY');

// Get an instance of the API
$attendly = new \Attendly\Attendly($user, $key);

// Create a quick event with the minimum required attributes
$event = array(
	'Name' => 'Test event via API',
	'Description' => '<p>This is just a test event. Note <strong>HTML</strong>strong></p>p>',
	'Deadline' => '2016-11-07T23:00:00Z',
	'Start' => '2016-11-10T23:00:00Z',
	'Stop' => '2016-11-10T23:00:00Z',
	'Status' => 'active',
);

$result = $attendly
    ->add_event($event)
    ->event_create();

var_dump($result);
