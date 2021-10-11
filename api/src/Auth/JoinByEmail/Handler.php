<?php

namespace App\Auth\JoinByEmail;

use App\Entity\User\User;
use App\Repository\UserRepository;
use App\Validator\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class Handler
{
    public UserRepository $users;
    public UserPasswordHasherInterface $hasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $hasher)
    {
        $this->users = $userRepository;
        $this->hasher = $hasher;
    }

    public function handle(Command $command): User
    {
        if ($this->users->hasByEmail($command->email)) {
            throw new ValidationException(new ConstraintViolationList([
                new ConstraintViolation(
                    'Email already exists',
                    null,
                    [],
                    $command->email,
                    'email',
                    $command->email
                )
            ]));
        }
        $user = User::byEmail(
            $command->email,
            $command->role
        );

        $user->setPassword(
            $this->hasher->hashPassword($user, $command->password)
        );

        $this->users->add($user);
        return $user;
    }
}
