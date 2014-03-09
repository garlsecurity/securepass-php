<?php

/*
 * This file is part of the Securepass package.
 *
 * (c) Paolo Mainardi <paolo@twinbit.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Securepass\Exception;

class Exception extends \Exception {
   public function __construct($message) {
     $this->message = $message;
   }
}
