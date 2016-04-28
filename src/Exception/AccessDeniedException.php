<?php
namespace Kr\OAuthServerBundle\Exception;

class AccessDeniedException extends OAuthException
{
    public function __construct($message = "Access denied")
    {
        $code = 403;
        $previous = null;
        parent::__construct($message, $code, $previous);
    }
}