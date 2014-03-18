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
use Securepass\Exception\Exception as SecurepassException;
use Guzzle\Common\Exception\InvalidArgumentException;

class Securepass extends AbstractSecurepass {

 /**
  * User API callback
  *
  * @param string $type API call type
  * @param string $config API parameters
  *
  * @return array|null Response array
  * @throws InvalidArgumentException
  */
  public function user($type, $params = array()) {
    $command_mapping = array(
      'auth'      => 'UserAuth',
      'info'      => 'UserInfo',
      'add'       => 'UserAdd',
      'provision' => 'UserProvision',
      'list'      => 'UserList',
      'delete'    => 'UserDelete'
    );

    if (!isset($command_mapping[$type])) {
      throw new InvalidArgumentException(sprintf('"%s" is not a valid user command.', $type));
    }

    // check if exists a specific implementation for this command
    $override_func = 'user' . ucfirst($type);
    if (function_exists($override_func)) {
      return $override_func($params);
    }

    $command = $this->client->getCommand($command_mapping[$type], $params);
    return $this->execute($command);
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

