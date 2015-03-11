<?php
require_once(__DIR__.'/../src/Attendly.php');


$attendly = new Attendly;

// Login (you should only do this to get the apikey once)
$user = $attendly->user_login('bob','password');
// Store the apikey
$attendly->apikey = $user['user']['apikey'];

// Get my list of events
$events = $attendly->event_list();

foreach ($events as $event)
{
	echo $event['event']['url']."\n";
}

// Get an events total ticket sales ($)
if ( ! empty($events))
{
	$event = $attendly->event_get($events[0]['event']['id']);
	echo $event['event']['gross_sales'];
}