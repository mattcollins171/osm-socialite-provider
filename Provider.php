<?php

namespace SocialiteProviders\osm;

use GuzzleHttp\RequestOptions;
use SocialiteProviders\Manager\OAuth2\AbstractProvider as AbstractProviderAlias;

class Provider extends AbstractProviderAlias
{
    protected function getCognitoUrl()
    {
        return $this->getConfig('osmUrl');
    }

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->getCognitoUrl().'/oauth/authorize', $state);
    }

    protected function getTokenUrl()
    {
        return $this->getCognitoUrl().'/oauth2/token';
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get($this->getCognitoUrl().'/oauth2/userInfo', [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        dd($user);
        return (new User())->setRaw($user)->map([
            'id'       => $user['sub'] ?? null,
            'nickname' => $user['nickname'] ?? null,
            'name'     => trim(Arr::get($user, 'given_name', '').' '.Arr::get($user, 'family_name', '')),
            'email'    => $user['email'] ?? null,
            'avatar'   => null,
        ]);
    }
}
