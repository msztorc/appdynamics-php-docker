<?php

$start = microtime(true);
$appd_logo = file_get_contents('appd.html');

echo $appd_logo;
usleep(10000);
$end = microtime(true);
echo 'Total time: ' . ($end-$start);
