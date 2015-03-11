<?php
require_once(__DIR__.'/../src/Attendly.php');


$attendly = new Attendly('testuser','8de323378f4427ec9b38');

// Create an event
$event = array(
	'Name' => 'Test event via API',
	'Description'=> '<p>This is just a test event. Note <strong>HTML</strong>strong></p>p>',
	'Deadline'=> '2015-11-07T23:00:00Z',
	'Start'=> '2015-11-10T23:00:00Z',
	'Stop'=> '2015-11-10T23:00:00Z',
	'Status'=> 'active'
);

$result = $attendly
	->add_event($event)
	->event_create();


var_dump($result);



