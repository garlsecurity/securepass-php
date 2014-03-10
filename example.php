<?php

require 'vendor/autoload.php';

use Securepass\Securepass;

$app_id = YOUR_APP_ID;
$app_secret = YOUR_APP_SECRET;

// base options
$config = array(
  'app_id'     => $app_id,
  'app_secret' => $app_secret
);

// configure a proxy
$config['request.options']['proxy'] = 'http://proxy.local';

// override base_url
$config['base_url'] = 'http://securepass.local';

$securepass = new Securepass($options);

$res = $securepass->ping();
$auth = $securepass->auth(USERNAME, PASSWORD);
