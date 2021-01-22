<?php

$json = file_get_contents('https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY');
$obj = json_decode($json, true);

echo '<img src="'. $obj['hdurl'] .'" alt="" /><br />';
echo $obj['explanation'];