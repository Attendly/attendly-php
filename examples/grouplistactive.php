<?php
require_once('html.php');
require_once('settings.php');
require_once('../src/Attendly.php');

$api = new Attendly(API_USER, API_KEY);

// Get the groups
$out = $api->group_list();


echo head();

echo '<h1>Group list</h1><pre><code class="JSON">';

echo print_r($out, TRUE);

echo '</code></pre>'.footer();
