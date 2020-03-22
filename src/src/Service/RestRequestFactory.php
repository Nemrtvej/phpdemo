<?php

namespace App\Service;

use App\Crate\RestRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RestRequestFactory
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * RestRequestFactory constructor.
     *
     * @param $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param Request $originalRequest
     *
     * @return RestRequest
     */
    public function getRestRequest(Request $originalRequest): RestRequest
    {
        $restRequest = new RestRequest(
            $originalRequest->get('orderField'),
            $originalRequest->get('orderDir'),
            $originalRequest->get('limit'),
            $originalRequest->get('page'),
        );

        $violations = $this->validator->validate($restRequest);

        if ($violations->count()) {
            throw new ValidatorException(sprintf('Bad request: %s', $this->serializeViolations($violations)));
        }

        return $restRequest;
    }

    /**
     * @param ConstraintViolationListInterface $violations
     *
     * @return string
     */
    private function serializeViolations(ConstraintViolationListInterface $violations): string
    {
        $result = '';

        foreach ($violations as $violation) {
            $result .= $violation->getMessage() . '\n';
        }

        return $result;
    }
}