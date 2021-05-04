<?php

namespace App\Tests\Unit\Presentation\Request;

use App\Presentation\Request\CreateEndpointRequest;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

class CreateEndpointTest extends KernelTestCase
{
    public function testSuccessfulCreating(): void
    {
        $request = $this->createRequest('fooPath', 201, 'Created');
        $createRequest = new CreateEndpointRequest($request);
        assertEquals('fooPath', $createRequest->getPath());
        assertEquals(201, $createRequest->getResponseCode());
        assertEquals('Created', $createRequest->getResponseBody());
    }

    public function testCreatingWIthNoPath(): void
    {
        $request = $this->createRequest(null, 401, 'Not Authorized');
        $createRequest = new CreateEndpointRequest($request);
        assertNull($createRequest->getPath());
    }

    protected function createRequest(?string $path, ?int $responseCode, ?string $responseBody): Request
    {
        $request = new Request();
        $request->setMethod('POST');
        $params = compact('path', 'responseCode', 'responseBody');
        $request->request->add($params);

        return $request;
    }
}
