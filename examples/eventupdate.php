<?php
require_once('html.php');
require_once('settings.php');
require_once('../src/Attendly.php');

$api = new Attendly(API_USER, API_KEY);
$api->server = API_SERVER;

// To work out which event to get, get a list of all the events and then get the
// first one.
$all = $api->event_list('active');

// Get the event ID
$eventId = $all['Result'][0]['ID'];

// Get the event
$event = $api->event_get($eventId);

// Make a change to the event
$event['Result']['Name'] = 'Edited event... '.rand(1,1000);

// Update the event
$out = $api->event_update($event['Result']);

echo head();

echo '<h1>Event update <span class="label label-success">A 204 means success</span></h1><pre><code class="JSON">';

echo print_r($out, TRUE);

echo '</code></pre>'.footer();
