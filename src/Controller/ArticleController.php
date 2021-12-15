<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Avis;
use App\Form\ArticleType;
use App\Form\AvisType;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/article/add", name="article_add")
     */
    public function addArtcile(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute("article_show", ['id' => $article->getId()]);
        }

        return $this->renderForm(
            'article/add.html.twig',
            ['form' => $form]
        );
    }

    /**
     * @Route("/article/{id<\d+>}", name="article_show")
     */
    public function showArticle(int $id, Request $request): Response 
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

            $avis = new Avis();
            $form = $this->createForm(AvisType::class, $avis);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $avis = $form->getData();
                $avis->setAuteur($this->getUser());
                $avis->setArticle($article);

            $em = $this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();
            }
        
        return $this->render('article/showArticle.html.twig',[
            'article'=>$article,
            'form'=>$form
        ]);
    }
}
