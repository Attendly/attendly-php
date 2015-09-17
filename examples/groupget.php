<?php
require_once('html.php');
require_once('settings.php');
require_once('../src/Attendly.php');

$api = new Attendly(API_USER, API_KEY);
$api->server = API_SERVER;

// To work out which group to get, get a list of all the groups and then get the
// first one.
$all = $api->group_list('active');

// Get the group ID
$groupId = $all['Result'][0]['ID'];

// Get the group
$out = $api->group_get($groupId);



echo head();

echo '<h1>Group get</h1><pre><code class="JSON">';

echo print_r($out, TRUE);

echo '</code></pre>'.footer();

