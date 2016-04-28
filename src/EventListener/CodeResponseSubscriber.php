<?php
namespace Kr\OAuthServerBundle\EventListener;

use Kr\OAuthServerBundle\Events\OAuthServerEvents;
use Kr\OAuthServerBundle\Events\GetResponseForAuthenticationEvent;
use Kr\OAuthServerBundle\Manager\AccessTokenManager;
use Kr\OAuthServerBundle\Manager\AuthorizationCodeManager;
use Kr\OAuthServerBundle\Manager\RefreshTokenManager;
use Kr\OAuthServerBundle\Model\ClientInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CodeResponseSubscriber implements EventSubscriberInterface
{
    use LoggerAwareTrait;

    public static function getSubscribedEvents()
    {
        return [
            OAuthServerEvents::AUTHORIZATION_REQUEST   => ["onAuthorizationRequest", 50],
        ];
    }

    /** @var AuthorizationCodeManager */
    protected $authorizationCodeManager;

    public function __construct(AuthorizationCodeManager $authorizationCodeManager)
    {
        $this->authorizationCodeManager = $authorizationCodeManager;
    }

    /**
     * @param GetResponseForAuthenticationEvent $event
     */
    public function onAuthorizationRequest(GetResponseForAuthenticationEvent $event)
    {
        if($event->getResponse() !== null) {
            return;
        }

        $request = $event->getRequest();

        // Only act on response_type=code
        $responseType   = $request->get("response_type");
        if($responseType !== "code") {
            return;
        }

        // Verify that authorization_code grants are allowed
        $client = $event->getClient();
        if(!$client->isAllowedGrantType("authorization_code")) {
            return;
        }



        $user           = $event->getUser();
        $redirectUri    = $request->get("redirect_uri");

        $authorizationCode = $this->authorizationCodeManager->createAuthorizationCode();
        $authorizationCode->setClient($client);
        $authorizationCode->setUser($user);
        $authorizationCode->setRedirectUri($redirectUri);
        $this->authorizationCodeManager->saveAuthorizationCode($authorizationCode);

        $state          = $request->get("state");

        $queryData = [
            "code"  => $authorizationCode->getCode(),
            "state"         => $state,
        ];

        $queryString = http_build_query($queryData);

        $url = $redirectUri . "?" . $queryString;

        $response = new RedirectResponse($url);

        $event->setResponse($response);
    }
}