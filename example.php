<?php
  include("securepass.php");

  $test = new SecurePass('app_id', 'app_secret');

  // Ping :)
  $res = $test->ping();
  echo "Ping received on IPv" . $res['ip_version'] . " from " . $res['ip'] . "\n"; 

  // Authenticate
  if ($test->user_auth('user', 'secret')) {
     echo "Authenticated\n";
  }
  else {
     echo "Access Denied\n";
  }

  // Info user
  var_dump($test->user_info('user'));
?>
