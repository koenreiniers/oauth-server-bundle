<?php
namespace Kr\OAuthServerBundle\EventListener;

use Kr\OAuthServerBundle\Exception\OAuthException;
use Psr\Log\LoggerAwareTrait;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    use LoggerAwareTrait;


    public function __construct()
    {

    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if($event->getResponse() !== null) {
            return;
        }
        $exception = $event->getException();

        if(!$exception instanceof OAuthException) {
            return;
        }

        $response = new JsonResponse([
            "code" => $exception->getCode(),
            "error" => $exception->getMessage(),
        ]);
        $event->setResponse($response);
    }
}