<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        $articles = $articleRepository->findAll();
        $category = $categoryRepository->findAll();

        return $this->render('home/home.html.twig', [
            'controller_name' => 'Bienvenue sur mon site !',
            'articles' => $articles,
            'categories' => $category
        ]);
    }

    #[Security('is_granted("ROLE_USER")')] //Autorise l'affichage des details seulements si l'utilisateur est connecté
    #[Route('/detail/{id}', name: 'detail')]
    public function show(ArticleRepository $articleRepository, $id): Response
    {

        $article = $articleRepository->find($id);

        return $this->render('home/show.html.twig', [
            'id' => $article
        ]);
    }


    #[Route('/showArticleCategory/{id}', name: 'categorie')]
    public function showArticlesCategorie(Category $categorie, CategoryRepository $categoryRepository): Response
    {

        $categories = $categoryRepository->findAll();

        if ($categorie) {

            $articles = $categorie->getArticles()->getValues();

        } else {

            return $this->redirectToRoute('app_home');
        }
        // $categorie = $categoryRepository->find($id);
        //dd($articles);

        return $this->render('home/home.html.twig', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

}