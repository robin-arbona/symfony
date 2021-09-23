<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\UserRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $postRepository, UserRepository $userRepository): Response
    {
        $posts = $postRepository->findAll();
        foreach ($posts as $post) {
            $userRepository->findOneBy(['id' => $post->getAuthor()->getId()]);
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post/{id}", name="post")
     */
    public function show(Post $post, UserRepository $userRepository): Response
    {
        $userRepository->findOneBy(['id' => $post->getAuthor()->getId()]);
        return $this->render('home/post.html.twig', [
            'post' => $post
        ]);
    }
}
