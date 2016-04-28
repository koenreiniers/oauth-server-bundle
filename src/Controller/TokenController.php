<?php
namespace Kr\OAuthServerBundle\Controller;

use Kr\OAuthServerBundle\Events\GetResponseForAuthenticationEvent;
use Kr\OAuthServerBundle\Events\OAuthServerEvents;
use Kr\OAuthServerBundle\Security\Authentication\Token\GrantToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Kr\OAuthServerBundle\Exception\AccessDeniedException;

/**
 * @Route("/oauth")
 */
class TokenController extends Controller
{
    /**
     * @Route("/token", name="kr.oauth_server.token.index")
     * @Template
     */
    public function indexAction(Request $request)
    {
        /** @var GrantToken $token */
        $token = $this->get("security.token_storage")->getToken();

        $client         = $token->getClient();
        $user           = $token->getUser();

        $logger = $this->get("logger");
        if($logger !== null) {
            $username = $user->getUsername();
            $clientId = $client->getId();
            $grantType = $token->getGrantType();
            $logger->debug("Token request for user $username from client $clientId, grant type: $grantType");
        }

        /** @var GetResponseForAuthenticationEvent $event */
        $event = new GetResponseForAuthenticationEvent($request, $client, $user);
        $event = $this->get("event_dispatcher")->dispatch(OAuthServerEvents::TOKEN_REQUEST, $event);

        $response = $event->getResponse();

        if($response === null) {
            throw new AccessDeniedException("Access denied");
        }

        return $response;
    }
}
