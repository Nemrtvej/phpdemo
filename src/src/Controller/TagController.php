<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Service\RestRequestFactory;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ValidatorException;

class TagController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RestRequestFactory
     */
    private $restRequestFactory;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * TagController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param RestRequestFactory     $restRequestFactory
     * @param Serializer             $serializer
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RestRequestFactory $restRequestFactory,
        Serializer $serializer
    ) {
        $this->entityManager = $entityManager;
        $this->restRequestFactory = $restRequestFactory;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function listTags(Request $request)
    {
        try {
            $restRequest = $this->restRequestFactory->getRestRequest($request);
        } catch (ValidatorException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $repo = $this->entityManager->getRepository(Tag::class);
        $context = new SerializationContext();
        $context->setGroups('tag_simple');

        return new Response(
            $this->serializer->serialize($repo->getListByRestRequest($restRequest), 'json', $context),
            Response::HTTP_OK,
            ['content-type' => 'json']
        );
    }
}