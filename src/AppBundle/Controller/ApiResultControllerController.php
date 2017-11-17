<?php

namespace AppBundle\Controller;

use function MongoDB\BSON\toJSON;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;





/**
 * Class ApiResultControllerController
 *
 * @package AppBundle\Controller
 * @Route(ApiResultCOntrollerController::RUTA_API)
 */
class ApiResultControllerController extends Controller
{

    const RUTA_API = '/api/v1/results';

    /**
     * Index
     *
     * @Route("/", name="result_index")
     */
    public function indexAction()
    {

        $repo = $this->getDoctrine()->getRepository('AppBundle:Results');
        $results = $repo->findAll();
        return empty($results)
            ? new JsonResponse(
                new Message(
                    Response::HTTP_NOT_FOUND,
                    Response::$statusTexts[404]
                ),
                Response::HTTP_NOT_FOUND
            )
            : new JsonResponse(['results' => $results]);
    }

    /**
     *
     * @param int $resultId Results id
     *
     * @return JsonResponse
     *
     * @Route("/{resultId}", name="miw_get_result", requirements={"userId": "\d+"})
     * @Method(Request::METHOD_GET)
     **/
    public function getResultAction(int $resultId)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Results');
        $result = $repo->findOneBy(['id' => $resultId]);

        return empty($result)
            ? new JsonResponse(
                new Message(Response::HTTP_NOT_FOUND, Response::$statusTexts[404]),
                Response::HTTP_NOT_FOUND
            )
            : new JsonResponse($result);
    }
}
