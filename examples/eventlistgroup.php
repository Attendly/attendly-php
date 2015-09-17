<?php
require_once('html.php');
require_once('settings.php');
require_once('../src/Attendly.php');

$api = new Attendly(API_USER, API_KEY);
$api->server = API_SERVER;

// Get a group 
$groups = $api->group_list();

// Get the events in that group
$out = $api->event_list('group',$groups['Result'][0]['ID']);

echo head();

echo '<h1>Event list for group <small>'.$groups['Result'][0]['Name'].'</small></h1><pre><code class="JSON">';

echo print_r($out, TRUE);

echo '</code></pre>'.footer();

