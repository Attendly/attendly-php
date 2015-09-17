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

// Get the events tickets
$out = $api->event_tickets($eventId);



echo head();

echo '<h1>Event tickets for event: <small>'.$all['Result'][0]['Name'].'</small></h1><pre><code class="JSON">';

echo print_r($out, TRUE);

echo '</code></pre>'.footer();
