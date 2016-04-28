<?php
namespace Kr\OAuthServerBundle\Grant;

class AuthorizationCode implements GrantInterface
{
    /**
     * @inheritdoc
     */
    public function getRequiredParameters()
    {
        return ["code", "client_id", "client_secret", "redirect_uri"];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return GrantTypes::AUTHORIZATION_CODE;
    }
}