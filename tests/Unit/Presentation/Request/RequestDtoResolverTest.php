<?php

namespace App\Tests\Unit\Presentation\Request;

use App\Presentation\Request\CreateEndpointRequest;
use App\Presentation\Request\RequestDtoInterface;
use App\Presentation\Request\RequestDtoResolver;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;
use Psr\Log\NullLogger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDtoResolverTest extends KernelTestCase
{
    public function testSupportsWithBadDto(): void
    {
        $metadataMock = $this->createMock(ArgumentMetadata::class);
        $metadataMock->method('getType')->willReturn(Request::class);
        $loggerMock = $this->createMock(NullLogger::class);

        $loggerMock->expects($this->never())->method('error');
        $metadataMock->expects($this->once())->method('getType');

        $dtoResolver = new RequestDtoResolver();
        $dtoResolver->setLogger($loggerMock);

        assertFalse($dtoResolver->supports(new Request(), $metadataMock));
    }

    public function testSupportsWithGoodRequest(): void
    {
        $metadataMock = $this->createMock(ArgumentMetadata::class);
        $metadataMock->method('getType')->willReturn(RequestDtoInterface::class);
        $loggerMock = $this->createMock(NullLogger::class);

        $dtoResolver = new RequestDtoResolver();
        $dtoResolver->setLogger($loggerMock);

        $metadataMock->expects($this->once())->method('getType');
        $loggerMock->expects($this->never())->method('error');

        assertTrue($dtoResolver->supports(new Request(), $metadataMock));
    }

    public function testSupportsWithNotExistsClassRequest(): void
    {
        $metadataMock = $this->createMock(ArgumentMetadata::class);
        $metadataMock->method('getType')->willReturn(null);
        $loggerMock = $this->createMock(NullLogger::class);
        $loggerMock->expects($this->once())->method('error');

        $dtoResolver = new RequestDtoResolver();
        $dtoResolver->setLogger($loggerMock);

        assertFalse($dtoResolver->supports(new Request(), $metadataMock));
    }

    public function testSuccessfulResolve(): void
    {
        $resolver = new RequestDtoResolver();
        $validatorMock = $this->createMock(ValidatorInterface::class);
        $validatorMock->method('validate')->willReturn(new ConstraintViolationList());
        $resolver->setValidator($validatorMock);
        $metaDataMock = $this->createMock(ArgumentMetadata::class);
        $metaDataMock->method('getType')->willReturn(CreateEndpointRequest::class);
        foreach ($resolver->resolve(new Request(), $metaDataMock) as $result) {
            assertInstanceOf(CreateEndpointRequest::class, $result);
        }
    }
}
