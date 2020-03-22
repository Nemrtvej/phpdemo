<?php

namespace App\Crate;

use Symfony\Component\Validator\Constraints as Assert;

class RestRequest
{
    /**
     * @var string|null
     */
    public ?string $orderField;

    /**
     * @var string|null
     * @Assert\Choice(choices={"ASC", "DESC"})
     */
    public ?string $orderDirection;

    public ?int $limit;

    public ?int $page;

    /**
     * RestRequest constructor.
     *
     * @param string|null $orderField
     * @param string|null $orderDirection
     * @param int|null    $limit
     * @param int|null    $page
     */
    public function __construct(
        ?string $orderField,
        ?string $orderDirection,
        ?int $limit,
        ?int $page
    ) {
        $this->orderField = $orderField;
        $this->orderDirection = $orderDirection;
        $this->limit = $limit;
        $this->page = $page;
    }

    /**
     * Return given orderDirection and orderField formatted for usage in Repository find* method
     *
     * @return array|null
     */
    public function getFormattedOrder(): ?array
    {
        if ($this->orderField && $this->orderDirection) {
            return [$this->orderField, $this->orderDirection];
        }

        return null;
    }
}