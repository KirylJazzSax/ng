<?php

namespace App\Auth\JoinByEmail;

use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    #[
        Assert\Email(
            message: "The email '{{ value }}' is not a valid email."
        ),
        Assert\NotBlank
    ]
    public string $email = '';

    #[Assert\NotBlank]
    public string $password = '';

    #[Assert\NotBlank]
    public string $role = '';
}
