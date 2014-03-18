<?php

namespace Securepass\Response;

use Guzzle\Service\Command\ResponseClassInterface;
use Guzzle\Service\Command\OperationCommand;

class Raw implements ResponseClassInterface
{
    protected $name;

    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse();
        $json = $response->json();
        return $json;
    }

    public function __construct($name)
    {
        $this->name = $name;
    }
}
