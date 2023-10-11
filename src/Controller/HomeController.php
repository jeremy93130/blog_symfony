<?php
namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('home/home.html.twig', [
            'controller_name' => 'Bienvenue sur mon site !',
            'articles' => $articles
        ]);
    }

    #[Route('/detail/{id}', name: 'detail')]
    public function show(ArticleRepository $articleRepository,$id): Response
    {

        $article = $articleRepository->find($id);

        return $this->render('home/show.html.twig', [
            'id' => $article
        ]); 
    }

}