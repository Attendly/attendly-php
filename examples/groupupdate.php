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
$group = $api->group_get($groupId);

// Make a change to the group
$group['Result']['Name'] = 'Edited group... '.rand(1,1000);

// Update the group
$out = $api->group_update($group['Result']);


echo head();

echo '<h1>Group update <span class="label label-success">A 204 means success</span></h1><pre><code class="JSON">';

echo print_r($out, TRUE);

echo '</code></pre>'.footer();
