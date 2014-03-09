<?php

namespace Securepass;

use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Securepass\Exception\Exception as SecurepassException;

abstract Class SecurepassAbstract {
  protected $client, $error;

  public function __construct($appId, $appSecret) {
    $this->client = new Client();

    // set Securepass deafult headers
    $this->client->setDefaultOption('headers/X-SecurePass-App-ID', $appId);
    $this->client->setDefaultOption('headers/X-SecurePass-App-Secret', $appSecret);
    $this->client->setDefaultOption('headers/Content-type', 'application/json');

    // set Useragent
    $this->client->setUserAgent('SecurePass-PHP/1.0"');

    // load services description
    $this->setServiceDescription();
  }

  protected function setServiceDescription() {
    $configs = array();

    // load service description file
    $serviceDescriptionFile = __DIR__ . '/config/services.json';

    // set service description
    $descriptions = ServiceDescription::factory($serviceDescriptionFile);
    $this->client->setDescription($descriptions);
  }

  protected function processResponse(\Guzzle\Service\Resource\Model $response) {
    $data = $response->toArray();

    // Return code value, it is always 0 if returned successfully (https://beta.secure-pass.net/trac/wiki/GeneralRules)
    if ($data['rc']) {
      if ($data['errorMsg']) {
        $this->error = $data['errorMsg'];
      }
      else {
        $this->error = 'Connection error, please try again.';
      }
      throw new SecurepassException($this->error);
    }
    // unset connection specific data
    unset($data['rc']);
    unset($data['errorMsg']);
    return $data;
  }
}
