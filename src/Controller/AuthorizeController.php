<?php
namespace Kr\OAuthServerBundle\Controller;

use Kr\OAuthServerBundle\Events\GetResponseForAuthenticationEvent;
use Kr\OAuthServerBundle\Events\OAuthServerEvents;
use Kr\OAuthServerBundle\Model\ClientInterface;
use Kr\OAuthServerBundle\Security\Authentication\Token\OAuthToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Kr\OAuthServerBundle\Exception\AccessDeniedException;
use Kr\OAuthServerBundle\Exception\AuthenticationException;
use Symfony\Component\VarDumper\VarDumper;


/**
 * @Route("/oauth")
 */
class AuthorizeController extends Controller
{
    /**
     * @Route("/auth", name="kr.oauth_server.authorization.index")
     * @Method("GET")
     * @Template
     */
    public function indexAction(Request $request)
    {
        $logger = $this->get("logger");

        /** @var UserInterface $user */
        $user = $this->getUser();

        $client = $this->getClient($request);

        if($logger !== null) {
            $username = $user->getUsername();
            $clientId = $client->getId();
            $logger->debug("Authorization request for user $username from client $clientId");
        }

        return [
            "client"    => $client,
            "user"      => $user,
        ];
    }

    /**
     * @param Request $request
     *
     * @return ClientInterface
     *
     * @throws AuthenticationException
     */
    protected function getClient(Request $request)
    {
        $clientId       = $request->get("client_id");
        $clientSecret   = $request->get("client_secret");

        /** @var ClientInterface $client */
        $client = $this->get("kr.oauth_server.manager.client")->getRepository()->findOneBy(["id" => $clientId, "secret" => $clientSecret]);
        if(!$client) {
            throw new AuthenticationException("Invalid client credentials");
        }
        $redirectUri = $request->get("redirect_uri");
        if(!in_array($redirectUri, $client->getRedirectUris())) {
            throw new AuthenticationException("Invalid redirect uri");
        }
        return $client;
    }

    protected function getDenyResponse(Request $request)
    {
        $logger = $this->get("logger");

        $user = $this->getUser();

        $client = $this->getClient($request);

        if($logger !== null) {
            $username = $user->getUsername();
            $clientId = $client->getId();
            $logger->info("Authorization denied by user $username for client $clientId");
        }

        $queryData = [
            "state" => $request->get("state"),
            "error" => "access_denied",
        ];

        $url = $request->get("redirect_uri") . "?" . http_build_query($queryData);

        return new RedirectResponse($url);
    }

    protected function getAcceptResponse(Request $request)
    {
        $logger = $this->get("logger");
        $eventDispatcher = $this->get("event_dispatcher");

        $user = $this->getUser();
        $client = $this->getClient($request);

        if($logger !== null) {
            $username = $user->getUsername();
            $clientId = $client->getId();
            $logger->debug("Authorization accepted by user $username for client $clientId");
        }

        /** @var GetResponseForAuthenticationEvent $event */
        $event = new GetResponseForAuthenticationEvent($request, $client, $user);
        $event = $eventDispatcher->dispatch(OAuthServerEvents::AUTHORIZATION_REQUEST, $event);

        $response = $event->getResponse();
        if($response === null) {
            throw new AccessDeniedException("Authorization failed");
        }

        return $response;
    }

    /**
     * @Route("/auth", name="kr.oauth_server.authorization.index_post")
     * @Method("POST")
     */
    public function indexPostAction(Request $request)
    {

        $action = $request->get("action");
        if($action === "deny") {
            return $this->getDenyResponse($request);
        } else if($action === "accept") {
            return $this->getAcceptResponse($request);
        }


    }
}
