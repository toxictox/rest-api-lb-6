<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Service\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends Controller
{
    /**
     * @Route("/user/create", name="homepage", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        /** @var ClientService $clientService */
        $clientService = $this->get(ClientService::class);
        $response = $clientService->create($request->request->all());

        return new JsonResponse($response, $response['responseCode']);
    }

    /**
     * @Route("/user/read/{id}", name="get", methods={"GET"})
     * @param Request $request
     * @return mixed
     */
    public function read(Request $request)
    {
        $entity = $this->getDoctrine()->getRepository(Client::class)->find($request->get('id'));
        $client = $this->get('serializer')->serialize($entity, 'json');

        if (!$entity instanceof Client) {
            return new JsonResponse([
                'message' => 'Request failed',
                'error' => 'Client not found',
                'responseCode' => 404,
            ], 404);
        }

        $response = new Response($client);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/user/update/{id}", name="update", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $clientService = $this->get(ClientService::class);
        $response = $clientService->update($request->get('id'), $request->request->all());

        return new JsonResponse($response, $response['responseCode']);

    }

    /**
     * @Route("/user/remove/{id}", name="delete", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        $clientService = $this->get(ClientService::class);
        $response = $clientService->remove($request->get('id'));

        return new JsonResponse($response, $response['responseCode']);
    }
}
