<?php

namespace App\Post\PostDefault;

use App\Entity\Post\Post;
use App\Repository\PostRepository;

class Handler
{
    public PostRepository $posts;

    public function __construct(PostRepository $userRepository)
    {
        $this->posts = $userRepository;
    }

    public function handle(Command $command): Post
    {
        $post = Post::default(
            $command->title,
            $command->description,
            $command->user
        );

        $this->posts->add($post);
        return $post;
    }
}
