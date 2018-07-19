<?php

namespace Wuwx\LaravelSocialitePassport;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class PassportProvider extends AbstractProvider implements ProviderInterface
{

    protected $serverUrl;

    public function serverUrl($url)
    {
        $this->serverUrl = $url;

        return $this;
    }

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->serverUrl . "/oauth/authorize", $state);
    }

    protected function getTokenUrl()
    {
        return $this->serverUrl . "/oauth/token";
    }

    protected function getUserByToken($token)
    {
        $userUrl = $this->serverUrl . "/api/user";
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
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }

    protected function getTokenFields($code)
    {
        return parent::getTokenFields($code) + ['grant_type' => 'authorization_code'];
    }
}
