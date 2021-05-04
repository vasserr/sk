<?php

namespace App\Presentation\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateEndpointRequest implements RequestDtoInterface
{
    /**
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    protected ?string $path;
    /**
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(100)
     * @Assert\LessThan(600)
     */
    protected ?int $responseCode;

    protected ?string $responseBody;

    public function __construct(Request $request)
    {
        $this->path = $request->get('path');
        $this->responseCode = $request->get('responseCode');
        $this->responseBody = $request->get('responseBody');
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getResponseCode(): ?int
    {
        return $this->responseCode;
    }

    public function getResponseBody(): ?string
    {
        return $this->responseBody;
    }
}
