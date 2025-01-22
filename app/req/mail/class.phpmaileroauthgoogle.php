<?php
declare(strict_types=1);

namespace PHPMailer\OAuth;

use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Grant\RefreshToken;

/**
 * PHPMailerOAuthGoogle - Wrapper for League OAuth2 Google provider.
 * @package PHPMailer
 * @author Marcus Bointon (@Synchro) <phpmailer@synchromedia.co.uk>
 * @link https://github.com/thephpleague/oauth2-client
 */
class PHPMailerOAuthGoogle
{
    private string $oauthUserEmail;
    private string $oauthRefreshToken;
    private string $oauthClientId;
    private string $oauthClientSecret;

    /**
     * PHPMailerOAuthGoogle constructor.
     * @param string $UserEmail
     * @param string $ClientSecret
     * @param string $ClientId
     * @param string $RefreshToken
     */
    public function __construct(
        string $UserEmail,
        string $ClientSecret,
        string $ClientId,
        string $RefreshToken
    ) {
        $this->oauthClientId = $ClientId;
        $this->oauthClientSecret = $ClientSecret;
        $this->oauthRefreshToken = $RefreshToken;
        $this->oauthUserEmail = $UserEmail;
    }

    /**
     * Get the Google OAuth provider.
     *
     * @return Google
     */
    private function getProvider(): Google
    {
        return new Google([
            'clientId' => $this->oauthClientId,
            'clientSecret' => $this->oauthClientSecret
        ]);
    }

    /**
     * Get the OAuth2 refresh grant.
     *
     * @return RefreshToken
     */
    private function getGrant(): RefreshToken
    {
        return new RefreshToken();
    }

    /**
     * Get the access token using the refresh token.
     *
     * @return \League\OAuth2\Client\Token\AccessToken
     */
    private function getToken()
    {
        $provider = $this->getProvider();
        $grant = $this->getGrant();
        return $provider->getAccessToken($grant, ['refresh_token' => $this->oauthRefreshToken]);
    }

    /**
     * Get the OAuth token encoded in base64 format.
     *
     * @return string
     */
    public function getOauth64(): string
    {
        $token = $this->getToken();
        return base64_encode("user=" . $this->oauthUserEmail . "\001auth=Bearer " . $token->getToken() . "\001\001");
    }
}
