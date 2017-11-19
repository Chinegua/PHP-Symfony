<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Results;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Message;
use Doctrine\Common\Collections\Criteria;
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
     * @Method(Request::METHOD_GET)
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


    /**
     * POST action
     *
     * @param Request $request request
     *
     * @return JsonResponse
     *
     * @Route("", name="miw_post_result")
     * @Method(Request::METHOD_POST)
     */
    public function postResultAction(Request $request)
    {
        $body = $request->getContent(false);
        $postData = json_decode($body, true);
        if (!isset($postData['user'], $postData['best_score'], $postData['last_score'])) { // 422 - Unprocessable Entity Faltan datos

            return new JsonResponse(
                new Message(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    Response::$statusTexts[422]
                ),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
/**
        $criteria = new Criteria();
        $criteria->where($criteria::expr()->eq('user_id', $postData['user']));
        $result_exist = $entityManager
            ->getRepository(Results::class)
            ->matching($criteria);**/

        $repo = $this->getDoctrine()->getRepository('AppBundle:Results');
        $user = $repo->findOneBy(['userId' => $postData['user']]);


        if (count($user)!= 0) {    // 400 - Bad Request

            return new JsonResponse(
                new Message(
                    Response::HTTP_BAD_REQUEST,
                    Response::$statusTexts[400]
                ),
                Response::HTTP_BAD_REQUEST
            );
        }

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $postData['user']]);
        // 201 - Created
        $result = new Results(
            $user,
            $postData['best_score'],
            $postData['last_score']
        );
        $entityManager->persist($result);
        $entityManager->flush();

        return new JsonResponse($user, Response::HTTP_CREATED);
    }

    /**
     *
     * @param int $resultId Result id
     *
     * @return Response
     *
     * @Route("/{resultId}", name="miw_delete_result")
     * @Method(Request::METHOD_DELETE)
     */
    public function deleteResultAction(int $resultId)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(Results::class)->findOneBy(['id' => $resultId]);


        if (empty($user)) {   // 404 - Not Found
            return new JsonResponse(
                new Message(
                    Response::HTTP_NOT_FOUND,
                    Response::$statusTexts[404]
                ),
                Response::HTTP_NOT_FOUND
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(
            new Message(
                Response::HTTP_NO_CONTENT,
                Response::$statusTexts[204]
            ),
            Response::HTTP_NO_CONTENT
        );

    }

    /**
     *
     * @param int $resultId
     * @return JsonResponse
     * @internal param int $userId
     * @Route(
     *     "/{resultId}",
     *     name = "miw_options_result",
     *     defaults = {"resultId" = 0},
     *     requirements = {"resultId": "\d+"}
     *     )
     * @Method(Request::METHOD_OPTIONS)
     */
    public function optionsResultAction(int $resultId)
    {
        $methods = ($resultId)
            ? ['GET', 'PUT', 'DELETE']
            : ['GET', 'POST'];

        return new JsonResponse(
            null,
            Response::HTTP_OK,
            ['Allow' => implode(', ', $methods)]
        );
    }
}
