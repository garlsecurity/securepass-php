<?php

namespace Securepass\Exception;

class Exception extends \Exception {
   public function __construct($message) {
     $this->message = $message;
   }
}
