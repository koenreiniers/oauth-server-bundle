<?php
namespace Kr\OAuthServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/appie")
 */
class ApiController extends Controller
{
    /**
     * @Route("", name="kr.oauth_server.api.index")
     */
    public function indexAction(Request $request)
    {
        return new JsonResponse("JO TJEK");
    }

}
