<?php
namespace Wec\OAuth2;

use Gap\Dto\DateTime;
use Gap\Base\Exception\NotLoginException;
use Gap\Base\RouteFilter\RouteFilterBase;
use Wec\OAuth2\OpenServerFactory;

class OAuth2Filter extends RouteFilterBase
{
    public function filter(): void
    {
        $route = $this->getRoute();
        $request = $this->getRequest();

        if ($route->getMode() !== 'open') {
            return;
        }

        if ($route->getAccess() === 'public') {
            return;
        }

        $authorization = $request->headers->get('Authorization');
        if (empty($authorization)) {
            throw new NotLoginException('Cannot find request header: "Authorization"');
        }

        $openServer = (new OpenServerFactory($this->getApp()))->create();
        $accessTokenService = $openServer->accessTokenService();
        $token = $accessTokenService->extractToken($authorization);
        if (empty($token)) {
            throw new NotLoginException('Cannot extract token from "Authorization" request header');
        }

        $accessToken = $accessTokenService->fetch($token);
        if (is_null($accessToken)) {
            throw new NotLoginException('Error access token');
        }

        $now = (new DateTime())->format('Y-m-d H:i:s');
        if ($accessToken->expired < $now) {
            throw new NotLoginException('access token expired');
        }

        $request->attributes->set('accessToken', $accessToken);
    }
}
