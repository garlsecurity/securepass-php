<?php
    /** 
     ** SecurePass' APIs core class
     ** (c) 2014 Giuseppe Paterno' (gpaterno@gpaterno.com)
     **          GARL Sagl (www.garl.ch)
     **
     **/ 

    $endpoint = "https://beta.secure-pass.net/"
    $api = "/api/v1/ping";
    $app_id = "your_app_id";
    $app_secret = "your_app_secret";
 
    // is cURL installed yet?
    if (!function_exists('curl_init')){
        die('cURL is not installed!');
    }
 
    // Curl resource handler
    $ch = curl_init();
 
 
    // Set URL to download
    curl_setopt($ch, CURLOPT_URL, $endpoint . $api);
 
    // User agent
    curl_setopt($ch, CURLOPT_USERAGENT, "SecurePass-PHP/1.0");
 
    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    // Verbose
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // SSL Settings
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Header 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	"Accept: application/json",
	"Content-type: application/json",
        "X-SecurePass-App-ID: " . $app_id,
        "X-SecurePass-App-Secret: " . $app_secret
    ));
 
    // Download the given URL, and return output
    $output = json_decode(curl_exec($ch), true);
 
    // Close the cURL resource, and free system resources
    curl_close($ch);
 
    echo "Ping received on IPv" . $output['ip_version'] . " from " . $output['ip'] . "\n";

?>
