<?php

namespace App\Presentation\Request;

use App\Supply\Traits\LoggerTrait;
use App\Supply\Traits\ValidatorTrait;
use Generator;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestDtoResolver implements ArgumentValueResolverInterface
{
    use ValidatorTrait;
    use LoggerTrait;

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        try {
            $reflection = new ReflectionClass($argument->getType());

            return $reflection->implementsInterface(RequestDtoInterface::class);
        } catch (ReflectionException $e) {
            $this->logger->error('Request DTO resolver error', [
                'exception' => $e,
                'class' => $argument->getType(),
            ]);
        }

        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $class = $argument->getType();
        $dto = new $class($request);
        $errors = $this->validator->validate($dto);

        if ($errors->count() > 0) {
            throw new BadRequestHttpException((string) $errors);
        }

        yield $dto;
    }
}
