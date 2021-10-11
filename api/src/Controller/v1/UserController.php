<?php

namespace App\Controller\v1;

use App\Auth\JoinByEmail\Command;
use App\Auth\JoinByEmail\Handler;
use App\Entity\User\Role;
use App\Validator\Validator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/api/v1/register', name: 'register', methods: ['POST', 'OPTIONS'])]
    public function register(
        Request   $request,
        Handler   $handler,
        Validator $validator,
        JWTTokenManagerInterface $manager
    ): Response
    {
        $data = $request->toArray();
        $command = new Command();
        $command->role = Role::user();
        $command->email = $data['email'] ?? '';
        $command->password = $data['password'] ?? '';
        $validator->validate($command);
        $user = $handler->handle($command);

        return $this->json(
            array_merge(
                $user->toArray(),
                ['token' => $manager->create($user)]
            )
        );
    }

//    #[Route('/api/v1/token', name: 'token', methods: ['POST', 'OPTIONS'])]
//    public function token(
//        Request                        $request,
//        Validator                      $validator,
//        \App\Auth\TokenByEmail\Handler $handler
//    ): Response
//    {
//        $data = $request->toArray();
//        $command = new \App\Auth\TokenByEmail\Command();
//
//        $command->email = $data['email'] ?? '';
//        $command->password = $data['password'] ?? '';
//        $validator->validate($command);
//
//        return $this->json(
//            $handler->handle($command)
//        );
//    }
}
