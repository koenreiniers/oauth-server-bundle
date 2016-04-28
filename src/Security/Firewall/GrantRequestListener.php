<?php
namespace Kr\OAuthServerBundle\Security\Firewall;

use Kr\OAuthServerBundle\Grant\DependencyInjection\GrantRegistry;
use Kr\OAuthServerBundle\Grant\GrantInterface;
use Kr\OAuthServerBundle\Security\Authentication\Token\GrantToken;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

class GrantRequestListener implements ListenerInterface
{
    use LoggerAwareTrait;

    /** @var GrantRegistry  */
    protected $grantRegistry;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var AuthenticationManagerInterface */
    protected $authenticationManager;

    /**
     * AuthorizationCodeListener constructor.
     * @param GrantRegistry $grantRegistry
     * @param TokenStorageInterface $tokenStorage
     * @param AuthenticationManagerInterface $authenticationManager
     */
    public function __construct(GrantRegistry $grantRegistry, TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager)
    {
        $this->grantRegistry = $grantRegistry;
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {

        $request = $event->getRequest();

        // Verify that there is a grant type present
        if(empty($request->get("grant_type"))) {
            return;
        }

        // Verify that grant type exists
        $grantType = $request->get("grant_type");
        if(!$this->grantRegistry->hasGrant($grantType)) {
            return;
        }
        $grant = $this->grantRegistry->getGrant($grantType);


        // Verify that all required parameters are present
        $credentials = [];
        $requiredParameters = $grant->getRequiredParameters();
        foreach($requiredParameters as $requiredParameter) {
            if(empty($request->get($requiredParameter))) {
                return;
            }
            $credentials[$requiredParameter] = $request->get($requiredParameter);
        }


        $token = new GrantToken($credentials);
        $token->setGrantType($request->get("grant_type"));

        try {
            $authenticatedToken = $this->authenticationManager->authenticate($token);
            $this->tokenStorage->setToken($authenticatedToken);
            return;
        } catch(AuthenticationException $e)
        {
            if($this->logger !== null) {
                $this->logger->notice("Grant request failed");
            }
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_FORBIDDEN);
        $event->setResponse($response);

    }
}