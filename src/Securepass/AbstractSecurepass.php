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

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Plugin\Backoff\BackoffPlugin;
use Guzzle\Service\Command\OperationCommand;

use Securepass\Exception\Exception as SecurepassException;

abstract Class AbstractSecurepass {
  protected $client, $error, $history;

  const BASE_URL = "https://beta.secure-pass.net";

 /**
  * Create Securepass client using Guzzle
  *
  * @param array $config Client Configuration options
  *
  */
  public function __construct($config = array())
  {
    $default = array('base_url' => self::BASE_URL);

    // The following values are required when creating the client
    $required = array(
        'base_url',
        'app_id',
        'app_secret'
    );

    $config = Collection::fromConfig($config, $default, $required);

    // Create a new Securepass client
    $this->client = new Client($config->get('base_url'), $config);

    // set Securepass deafult headers
    $this->client->setDefaultOption('headers/X-SecurePass-App-ID', $config->get('app_id'));
    $this->client->setDefaultOption('headers/X-SecurePass-App-Secret', $config->get('app_secret'));
    $this->client->setDefaultOption('headers/Content-type', 'application/json');

    // set Useragent
    $this->client->setUserAgent('SecurePass-PHP/1.0"');

    // load services description
    $this->setServiceDescription();

    // Use a static factory method to get a backoff plugin using the exponential backoff strategy
    $backoffPlugin = BackoffPlugin::getExponentialBackoff();

    // Add the backoff plugin to the client object
    $this->client->addSubscriber($backoffPlugin);
  }

  /**
   * @return Object GuzzleClient instance
   */
  public function getClient() {
    return $this->client;
  }

 /**
  *  Set Guzzle Securepass services description file
  */
  protected function setServiceDescription()
  {
    // load service description file
    $serviceDescriptionFile = __DIR__ . '/Resources/services.json';

    // set service description
    $descriptions = ServiceDescription::factory($serviceDescriptionFile);
    $this->client->setDescription($descriptions);
  }

  /**
  * @param OperationCommand $command Guzzle operation command
  *
  * @throws SecurepassException
  */
  protected function execute(OperationCommand $command)
  {
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
  protected function processResponse(Array $response)
  {
    // unset connection specific data
    unset($response['rc']);
    unset($response['errorMsg']);
    return $response;
  }

}

