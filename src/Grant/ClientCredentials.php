<?php
namespace Kr\OAuthServerBundle\Grant;

class ClientCredentials implements GrantInterface
{
    /**
     * @inheritdoc
     */
    public function getRequiredParameters()
    {
        return ["client_id", "client_secret"];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return GrantTypes::CLIENT_CREDENTIALS;
    }
}