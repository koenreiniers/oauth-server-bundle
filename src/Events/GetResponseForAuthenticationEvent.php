<?php
namespace Kr\OAuthServerBundle\Events;

use Kr\OAuthServerBundle\Model\ClientInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class GetResponseForAuthenticationEvent extends Event
{
    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var ClientInterface */
    protected $client;

    /** @var UserInterface */
    protected $user;

    public function __construct(Request $request, ClientInterface $client, UserInterface $user)
    {
        $this->request = $request;
        $this->client = $client;
        $this->user = $user;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }


}