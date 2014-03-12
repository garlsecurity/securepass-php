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

/* User operations */

// Authentication
$auth = array('username' => 'text@example.com',
              'password' => 'foobar')
$res = $securepass->user('auth', $auth);

// Create user
$user = array(
  'username' => 'foobar',
  'name'     => 'Foo',
  'surname'  => 'Bar',
  'email'    => 'foobar@example.com',
  'mobile'   => '+395551234567890'
);
$res = $securepass->user('create', $user);

// Provision user
$provision = array(
  'username' => "foobar@example.com",
  'swtoken' => "android"
);
$res = $securepass->user('provision', $provision);

// List users
$res = $securepass->user('list');


