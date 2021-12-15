<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $articles
        ]);
    }

    /**
     * @Route("/article/{id<\d+>}", name="article_show")
     */
    public function showArticle(int $id): Response 
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);
        
        return $this->render('article/showArticle.html.twig',[
            'article'=>$article
        ]);
    }
}
