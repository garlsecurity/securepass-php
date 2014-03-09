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

class Securepass extends SecurepassAbstract {

  /**
  * @param string $appId Securepass AppID
  * @param string $appSecret Securepass AppSecret
  */
  public function __construct($appId, $appSecret) {
    parent::__construct($appId, $appSecret);
  }

  /**
  * @param string $username Username to authenticate
  * @param string $secret User secret
  *
  * @return array|null Response array
  */
  public function auth($username, $secret) {
    $command = $this->client->getCommand('UserAuth', array('username' => $username, 'secret' => $secret));
    $response = $this->client->execute($command);
    return $this->processResponse($response);
  }

  /**
  *
  * @return array|null Response array
  */
  public function ping() {
    $command = $this->client->getCommand('Ping');
    $response = $this->client->execute($command);
    return $this->processResponse($response);
  }
}

