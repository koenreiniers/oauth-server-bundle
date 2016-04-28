<?php
namespace Kr\OAuthServerBundle\Exception;

class AuthenticationException extends OAuthException
{
    public function __construct($message = "Authentication failed")
    {
        $code = 403;
        $previous = null;
        parent::__construct($message, $code, $previous);
    }
}