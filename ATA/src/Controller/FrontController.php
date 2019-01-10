<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 07/01/2019
 * Time: 17:38
 */

namespace App\Controller;

use App\Entity\Article;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('front/index.html.twig');
    }

    /**
     *
     * @Route("/contact", name="front_contact")
     */
    public function contact()
    {
        return $this->render('front/contact.html.twig');
    }
    
    /**
     * @Route("/galerie",name="front_galerie")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function galerie()
    {
        return $this->render('front/galerie.html.twig');
    }

    /**
     * @Route("/categorie",name="front_categorie")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categorie()
    {
        return $this->render('front/categorie.html.twig');
    }

    /**
     * Affiche LES articles
     * @Route("/articles",name="front_les_articles" )
     */
    public function lesArticles()
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();


        return $this->render('front/lesArticles.html.twig', [
            'article' => $article
        ]);


    }


    /**
     * Affiche UN article
     * @Route("/{slug<[a-zA-Z1-9\-_\/]+>}_{id<\d+>}.html",
     *     name="front_article")
     *
     * @param Article $article
     * @param $slug
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
//
    public function article($slug, article $article = null) // par défaut vaut null
    {
//        #####################################
//               REQUETE TEST DE RECUP

//        $article = $this->getDoctrine()
//            ->getRepository(Article::class)
//            ->find(5);
//
//        return $this->render('front/article.html.twig',
//            [    'article' => $article ]);
//        #####################################

        #on s'assure que l'article ne soit pas existant
        if(null === $article){

            return $this->redirectToRoute('index',[],\Symfony\Component\HttpFoundation\Response::HTTP_MOVED_PERMANENTLY);
        }

        #verification du SLUG
        if($article->getSlug() !== $slug){
            return $this->redirectToRoute('front/article.html.twig',[
                'slug'      => $article->getSlug(),
                'id'        => $article->getId()
            ]);

        }

        return $this->render('front/article.html.twig',[
            'article' => $article
        ]);

    }


    /**
     * @Route("/apropos", name="front_apropos")
     *
     */
    public function apropos()
    {
        return $this->render('front/apropos.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/evenement", name="front_evenement")
     */
    public function evenement()
    {
        return $this->render('front/evenement.html.twig');
    }


    /**
     * @Route("/event", name="evenement_afficheEvenement")
     */
    public function afficheEvenement()
    {
        return $this->render('evenement/afficheEvenement.html.twig');
    }

}


