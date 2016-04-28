<?php
namespace Kr\OAuthServerBundle\Grant;

class RefreshToken implements GrantInterface
{
    /**
     * @inheritdoc
     */
    public function getRequiredParameters()
    {
        return ["refresh_token", "client_id", "client_secret"];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return GrantTypes::REFRESH_TOKEN;
    }
}