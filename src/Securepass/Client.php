<?php

namespace Securepass;

use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Symfony\Component\Config\FileLocator;

class Client {
  private $client;

  public function __construct($appId, $appSecret) {
    $this->client = new Client();


    // set Securepass deafult headers
    $this->client->setDefaultOption('headers/X-SecurePass-App-ID', $appId);
    $this->client->setDefaultOption('headers/X-SecurePass-App-Secret', $appSecret);

    // set Useragent
    $this->client->setUserAgent('SecurePass-PHP/1.0"');
  }

  private function setServiceDescription() {
    $configs = array();

    // load service description file
    $configDirectories = array(__DIR__ . '/config');
    $locator = new FileLocator($configDirectories);
    $serviceDescriptionFile = $locator->locate('services.json', null, true);

    // set service description
    $descriptions = ServiceDescription::factory($serviceDescriptionFile);
    $this->client->setDescription($descriptions);
  }
}
