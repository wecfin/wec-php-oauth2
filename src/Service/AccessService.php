<?php
namespace Wec\OAuth2\Service;

use Gap\Open\Dto\AccessTokenDto;

class AccessService extends ServiceBase
{
    public function accessToken(array $opts): ?AccessTokenDto
    {
        $accessToken = $this->createAccessToken($opts);
        if (is_null($accessToken)) {
            return null;
        }

        if (strpos($accessToken->scope, 'openId') !== false) {
            $accessToken->idToken = (string) $this->idToken(
                $accessToken->userId,
                $opts['companyCode']
            );
        }

        return $accessToken;
    }

    public function create(array $opts): AccessTokenDto
    {
        return $this->getOpenServer()->accessTokenService()
            ->create($opts);
    }

    private function createAccessToken(array $opts): ?AccessTokenDto
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
