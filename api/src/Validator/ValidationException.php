<?php

namespace App\Validator;

use LogicException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidationException extends LogicException
{
    private ConstraintViolationListInterface $violations;

    public function __construct(
        ConstraintViolationListInterface $violations,
        string $message = 'Invalid input.',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->violations = $violations;
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }

    public function violationsAsArray(): array
    {
        $errMessages = [];
        foreach ($this->getViolations() as $error) {
            $errMessages[$error->getPropertyPath()] = $error->getMessage();
        }
        return $errMessages;
    }
}
