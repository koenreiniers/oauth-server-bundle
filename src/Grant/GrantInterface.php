<?php
namespace Kr\OAuthServerBundle\Grant;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

interface GrantInterface
{

    /**
     * Returns an array of required parameters for this grant
     *
     * @return array
     */
    public function getRequiredParameters();

    /**
     * Returns the unique name of this grant
     *
     * @return string
     */
    public function getType();
}