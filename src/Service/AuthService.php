<?php
namespace Wec\OAuth2\Service;

use Gap\Open\Dto\AppDto;
use Gap\Open\Dto\AuthCodeDto;

class AuthService extends ServiceBase
{
    public function authCode(array $opts): ?AuthCodeDto
    {
        return $this->getOpenServer()->authCodeGrant()
            ->authCode(
                $opts['appId'],
                $opts['userId'],
                $opts['redirectUrl'],
                $opts['scope'] ?? ''
            );
    }

    public function app(string $appId): ?AppDto
    {
        return $this->getOpenServer()
            ->appService()->fetch($appId);
    }
}
