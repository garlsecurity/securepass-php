<?php

/*
 * This file is part of the Securepass package.
 *
 * (c) Paolo Mainardi <paolo@twinbit.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Securepass;

use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Securepass\Exception\Exception as SecurepassException;

abstract Class AbstractSecurepass extends Client {
  protected $client, $error;

  /**
  * @param string $appId Securepass AppID
  * @param string $appSecret Securepass AppSecret
  */
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

    // check if everything works as expected, ping Securepass API.
    $this->ping();
  }

 /**
  *  Set Guzzle Securepass services description file
  */
  protected function setServiceDescription() {
    $configs = array();

    // load service description file
    $serviceDescriptionFile = __DIR__ . '/Resources/services.json';

    // set service description
    $descriptions = ServiceDescription::factory($serviceDescriptionFile);
    $this->client->setDescription($descriptions);
  }

  /**
  * @param \Guzzle\Service\Command\OperationCommand $command Guzzle operation command
  *
  * @throws SecurepassException
  */
  protected function execute(\Guzzle\Service\Command\OperationCommand $command) {
    $response = $this->client->execute($command);
    $data = $response->toArray();

    // Return code value, it is always 0 if returned successfully (https://beta.secure-pass.net/trac/wiki/GeneralRules)
    if ($data['rc']) {
      $this->error = 'Something goes wrong, error: "%s"';
      throw new SecurepassException(sprintf($this->error, $data['errorMsg']));
    }
    return $this->processResponse($data);
  }

  /**
  * Process response, throw errors if any and returns data array.
  *
  * @param Array $response Reponse from the client
  * @return array|null Response array
  */
  protected function processResponse(Array $response) {
    // unset connection specific data
    unset($response['rc']);
    unset($response['errorMsg']);
    return $response;
  }
}
