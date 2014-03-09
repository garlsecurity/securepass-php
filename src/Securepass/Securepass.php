<?php

namespace Securepass;

class Securepass extends SecurepassAbstract {
  public function __construct($appId, $appSecret) {
    parent::__construct($appId, $appSecret);
  }

  /**
   * Authorize user
   */
  public function auth($username, $password) {
    $command = $this->client->getCommand('UserAuth', array('username' => $username, 'password' => ''));
    $response = $this->client->execute($command);
    return $response;
  }

  /**
   * Ping Securepass API
   */
  public function ping() {
    $command = $this->client->getCommand('Ping');
    $response = $this->client->execute($command);
    return $this->processResponse($response);
  }
}
