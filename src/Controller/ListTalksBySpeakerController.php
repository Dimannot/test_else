<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ListTalksBySpeakerService;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Entity\Talk;

class ListTalksBySpeakerController
{
    private ListTalksBySpeakerService $listTalksBySpeakerService;

    public function __construct(ListTalksBySpeakerService $listTalksBySpeakerService)
    {
        $this->listTalksBySpeakerService = $listTalksBySpeakerService;
    }

    /**
    * List talks by speaker route.
    * @Route("/speakers/{id}/talks", methods={"GET"})
    * @OA\Parameter(
    *    name="id",
    *    in="path",
    *    description="The field used to identify a speaker",
    * )
    *
    * @OA\Response(
    *     response=200,
    *     description="Returns array of talks",
    *      @OA\JsonContent(
    *        type="array",
    *        @OA\Items(ref=@Model(type=Talk::class))
    *     )
    * )
    */
    public function handle(int $id, Request $request): Response
    {
        try {
            $response = $this->listTalksBySpeakerService->execute($id);

            return (new JsonResponse())
            ->setStatusCode(200)
            ->setData($response);
        } catch (\Exception $error) {
            var_dump($error);
            return (new JsonResponse())
            ->setStatusCode($error->getCode())
            ->setData($error->__toString());
        }
    }
}
