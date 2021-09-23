<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PublicUserFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


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

    /**
     * @Route("/signup", name="signup")
     */
    public function signup(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(PublicUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setPassword($userPasswordHasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->renderForm('home/signup.html.twig', [
            'form' => $form,
        ]);
    }
}
