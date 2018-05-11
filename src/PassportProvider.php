<?php

namespace Wuwx\LaravelSocialitePassport;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class PassportProvider extends AbstractProvider implements ProviderInterface
{

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('http://localhost:8000/oauth/authorize', $state);
    }

    protected function getTokenUrl()
    {
        return 'http://localhost:8000/oauth/token';
    }

    protected function getUserByToken($token)
    {
        $userUrl = 'http://localhost:8000/oauth/user';
        $response = $this->getHttpClient()->request("GET", $userUrl, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        $user = json_decode($response->getBody(), true);
        return $user;
    }

    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['id'],
            'nickname' => $user['login'],
            'avatar' => $user['avatar'],
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }

    protected function getTokenFields($code)
    {
        return parent::getTokenFields($code) + ['grant_type' => 'authorization_code'];
    }
}
