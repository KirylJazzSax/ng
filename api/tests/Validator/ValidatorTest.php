<?php

namespace App\Tests\Validator;

use App\Validator\ValidationException;
use App\Validator\Validator;
use Exception;
use stdClass;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorTest extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    public function testValid()
    {
        $c = new stdClass();

        $origin = $this->createMock(ValidatorInterface::class);
        $origin->expects(self::once())
            ->method('validate')
            ->with(self::equalTo($c))
            ->willReturn(new ConstraintViolationList());

        $validator = new Validator($origin);
        $validator->validate($c);
    }

    public function testNotValid()
    {
        $c = new stdClass();

        $origin = $this->createMock(ValidatorInterface::class);
        $origin->expects(self::once())
            ->method('validate')
            ->with(self::equalTo($c))
            ->willReturn(new ConstraintViolationList([
                    $this->createMock(ConstraintViolation::class)
                ]
            ));

        $validator = new Validator($origin);
        try {
            $validator->validate($c);
            self::fail('Exception not thrown');
        } catch (Exception $exception) {
            self::assertInstanceOf(ValidationException::class, $exception);
        }
    }
}
