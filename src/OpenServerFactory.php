<?php
namespace Wec\OAuth2;

use Gap\Base\App;
use Gap\Open\Server\OpenServer;

class OpenServerFactory
{
    private $app;
    private $cnnName = 'default';
    private $cacheName = 'oauth2';

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function create(): OpenServer
    {
        $app = $this->app;
        $openConfig = $app->getConfig()->config('open');

        return new OpenServer([
            'cnn' => $app->getDmg()->connect($this->cnnName),
            'cache' => $app->getCmg()->connect($this->cacheName),
            'publicKey' => $openConfig->str('publicKey'),
            'privateKey' => $openConfig->str('privateKey')
        ]);
    }
}
