<?php

require 'vendor/autoload.php';

use Securepass\Securepass;

$app_id = YOUR_APP_ID;
$app_secret = YOUR_APP_SECRET;

$client = new Securepass($app_id, $app_secret);
$res = $client->ping();
$auth = $client->auth(USERNAME, PASSWORD);
