<?php

namespace App\Controller\v1;

use App\Post\PostDefault\Command;
use App\Post\PostDefault\Handler;
use App\Repository\PostRepository;
use App\Validator\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PostController extends AbstractController
{
    private PostRepository $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/api/v1/post', name: 'get_posts', methods: ['GET', 'OPTIONS'])]
    public function index(): Response
    {
        return $this->json($this->repository->findAll());
    }

    #[Route('/api/v1/post', name: 'create_post_default', methods: ['POST', 'OPTIONS'])]
    public function add(
        Request $request,
        Handler $handler,
        Validator $validator,
        Security $security
    ): Response
    {
        $data = $request->toArray();
        $command = new Command();
        $command->title = $data['title'] ?? '';
        $command->description = $data['description'] ?? '';
        $command->user = $security->getUser();
        $validator->validate($command);
        $post = $handler->handle($command);
        return $this->json([
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'user_id' => $post->getUser()->getId()
        ]);
    }
}
