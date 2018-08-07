<?php
namespace Wec\OAuth2\Service;

use Gap\Open\Dto\AccessTokenDto;

class AccessService extends ServiceBase
{
    public function create(array $opts): AccessTokenDto
    {
        return $this->getOpenServer()->accessTokenService()
            ->create($opts);
    }

    public function accessToken(array $opts): ?AccessTokenDto
    {
        $openServer = $this->getOpenServer();
        $grantType = $opts['grantType'];

        if ($grantType === 'authCode') {
            return $openServer->authCodeGrant()
                ->accessToken($opts['appId'], $opts['code']);
        }

        if ($grantType ==='openId') {
            return $openServer->openIdGrant()
                ->accessToken($opts['appId'], $opts['idToken']);
        }

        if ($grantType === 'clientCredentials') {
            return $openServer->clientCdGrant()
                ->accessToken($opts['appId'], $opts['appSecret']);
        }
    }
}
