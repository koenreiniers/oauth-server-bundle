<?php
namespace Kr\OAuthServerBundle\Security\Firewall;

use Kr\OAuthServerBundle\Security\Authentication\Token\GrantToken;
use Kr\OAuthServerBundle\Security\Authentication\Token\OAuthToken;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

class AccessTokenListener implements ListenerInterface
{
    use LoggerAwareTrait;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var AuthenticationManagerInterface */
    protected $authenticationManager;

    /**
     * AccessTokenListener constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param AuthenticationManagerInterface $authenticationManager
     */
    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();


        if(empty($request->headers->get("Authorization"))) {
            return;
        }

        $authHeader = $request->headers->get("Authorization");
        if(strpos($authHeader, " ") === false) {
            return;
        }
        list($tokenType, $token) = explode(" ", $authHeader, 2);

        if(strtolower($tokenType) !== "bearer") {
            return;
        }

        // Verify that there is an access_token present
        /*
        if(empty($request->get("access_token"))) {
            return;
        }
        $token = $request->get("access_token");*/

        $unauthenticatedToken = new OAuthToken();
        $unauthenticatedToken->setToken($token);

        try {
            $authenticatedToken = $this->authenticationManager->authenticate($unauthenticatedToken);
            $this->tokenStorage->setToken($authenticatedToken);
            return;
        } catch(AuthenticationException $e)
        {
            if($this->logger !== null) {
                $this->logger->notice("Access token authentication failed");
            }
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_FORBIDDEN);
        $event->setResponse($response);

    }
}