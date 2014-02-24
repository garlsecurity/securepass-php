<?php
    /** 
     ** SecurePass' APIs core class
     ** (c) 2014 Giuseppe Paterno' (gpaterno@gpaterno.com)
     **          GARL Sagl (www.garl.ch)
     **
     **/ 

class SecurePass {


    // Global var
    public $endpoint = "https://beta.secure-pass.net/";
    public $app_id, $app_secret;

    public function __construct($app_id = NULL, $app_secret = NULL, $endpoint = NULL) {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;

        if ($endpoint != NULL) {
           $this->endpoint = $endpoint;
        }
    }


    function SendRequest($path, $content = NULL) {
 
        // is cURL installed yet?
        if (!function_exists('curl_init')){
            die('cURL is not installed!');
        }
 
        // Curl resource handler
        $ch = curl_init();
 
        // Set URL to download
        curl_setopt($ch, CURLOPT_URL, $this->endpoint . $path);
 
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
            "X-SecurePass-App-ID: " . $this->app_id,
            "X-SecurePass-App-Secret: " . $this->app_secret
        ));

        // Send data
        if ($content != NULL) {
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
        }
 
        // Download the given URL, and return output
        $output = json_decode(curl_exec($ch), true);
 
        // Close the cURL resource, and free system resources
        curl_close($ch);

        // Return the array
        return $output;
    }


    // Ping SecurePass service
    function ping() {
        $result = $this->SendRequest("/api/v1/ping");

        // If we have a non zero result, let's fire an error
        if ($result["rc"] == 0) {
           unset($result["rc"]);
           unset($result["errorMsg"]);
   
           return $result;
        }
        else {
           die($result["errorMsg"]);
        }

    }

   
    // Authenticate
    function user_auth($username, $secret) {
        $request = array (
		"USERNAME" => $username,
		"SECRET"   => $secret,
        );

        $result = $this->SendRequest("/api/v1/users/auth", $request);

        // If we have a non zero result, let's fire an error
        if ($result["rc"] == 0) {
           return $result["authenticated"];
        }
        else {
           die($result["errorMsg"]);
        }

    }


    // Get user information
    function user_info($username) {
        $request = array (
		"USERNAME" => $username,
        );

        $result = $this->SendRequest("/api/v1/users/info", $request);

        // If we have a non zero result, let's fire an error
        if ($result["rc"] == 0) {
           unset($result["rc"]);
           unset($result["errorMsg"]);
   
           return $result;
        }
        else {
           die($result["errorMsg"]);
        }
    }
 
}

?>
