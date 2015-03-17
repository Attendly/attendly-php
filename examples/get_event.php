<?php
require_once(__DIR__.'/../src/Attendly.php');


$attendly = new Attendly('testuser', '8de323378f4427ec9b38');

// Get an event
$result = $attendly->event_get(123);

var_dump($result);
