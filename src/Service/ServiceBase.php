<?php
namespace Wec\OAuth2\Service;

use Wec\OAuth2\OpenServerFactory;

class ServiceBase extends \Gap\Base\Service\ServiceBase
{
    protected $openServer;

    protected function getOpenServer()
    {
        if ($this->openServer) {
            return $this->openServer;
        }

        return $this->openServer = (new OpenServerFactory($this->getApp()))
            ->create();
    }
}
