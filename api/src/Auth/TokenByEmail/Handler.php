<?php

namespace App\Auth\TokenByEmail;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Validator\ValidationException;
use JetBrains\PhpStorm\ArrayShape;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class Handler
{
    private UserRepository $users;
    private UserPasswordHasherInterface $hasher;
    private JWTTokenManagerInterface $manager;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $hasher,
        JWTTokenManagerInterface $manager
    )
    {
        $this->users = $userRepository;
        $this->hasher = $hasher;
        $this->manager = $manager;
    }

    #[ArrayShape(['token' => "string"])]
    public function handle(Command $command): array
    {
        $user = $this->users->findOneBy(['email' => $command->email]);

        if (!$user) {
            throw new NotFoundHttpException('User with this email not found');
        }

        if (!$this->hasher->isPasswordValid($user, $command->password)) {
            throw new ValidationException(new ConstraintViolationList([
                new ConstraintViolation(
                    'Password not valid',
                    null,
                    [],
                    $command->password,
                    'password',
                    $command->password
                )
            ]));
        }

        return [
            'token' => $this->manager->create($user)
        ];
    }
}
