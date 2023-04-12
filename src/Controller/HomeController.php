<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        return $this->render('home/index.html.twig', [
            'current_menu' => 'app_home_index',
            'posts' => $posts
        ]);
    }
}
