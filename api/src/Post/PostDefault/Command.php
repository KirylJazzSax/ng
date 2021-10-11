<?php

namespace App\Post\PostDefault;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
class Command
{
    #[Assert\NotBlank]
    public $title;
    #[Assert\NotBlank]
    public $description;
    #[Assert\NotBlank]
    public UserInterface $user;
}
