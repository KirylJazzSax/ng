<?php

namespace App\Listeners\Exception;

use App\Validator\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ValidationExceptionHandler
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof ValidationException) {
            $event->setResponse(new JsonResponse($exception->violationsAsArray(), Response::HTTP_UNPROCESSABLE_ENTITY));
        }
    }
}
