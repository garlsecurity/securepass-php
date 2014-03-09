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

class Securepass extends AbstractSecurepass {
  /**
  * Authenticate the user
  *
  * @param string $username Username to authenticate
  * @param string $secret User secret
  *
  * @return array|null Response array
  */
  public function userAuth($username, $secret)
  {
    $command = $this->client->getCommand('UserAuth', array('username' => $username, 'secret' => $secret));
    $res = $this->execute($command);
    return $res;
  }

  /**
  * Get user informations.
  *
  * @param string $username Securepass username
  *
  * @return array|null Response array
  */
  public function userInfo($username)
  {
    $command = $this->client->getCommand('UserInfo', array('username' => $username));
    $res = $this->execute($command);
    return $res;
  }

  /**
  * Ping Securepass API
  *
  * @return array|null Response array
  */
  public function ping()
  {
    $command = $this->client->getCommand('Ping');
    $res = $this->execute($command);
    return $res;
  }
}

