<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 07/01/2019
 * Time: 17:38
 */

namespace App\Controller;

use App\Entity\Evenement;
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
     * @Route("/evenements",name="front_categorie_evenements")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categorieEvenement()
    {
        $evenement = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->findAll();


        return $this->render('front/categorie.html.twig', [
            'evenement' => $evenement
        ]);


    }

    /**
     * @Route("/{categorie<[a-zA-Z0-9-/]+>}/{slug<[a-zA-Z0-9-/]+>}_{id<\d+>}.html",
     *     name="front_evenement")
     * @param $categorie
     * @param $slug
     * @param Evenement|null $evenement
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function evenement($categorie, $slug, Evenement $evenement = null)

    {
        # Exemple d'URL
        # /politique/vinci-autoroutes-va-envoyer-une-facture-aux-automobilistes_9841.htmlevenement-final

        #$article = $this->getDoctrine()
        #                               ->getRepository(Article::class)
        #                              ->find($id);

        if (null === $evenement) {
            return $this->redirectToRoute('front_categorie_evenements', [], \Symfony\Component\HttpFoundation\Response::HTTP_MOVED_PERMANENTLY);
        }

        #Verification du SLUG
        if ($evenement->getSlug() !== $slug || $evenement->getCategories()->getSlug() !== $categorie) {
            return $this->redirectToRoute('front_evenement', [
                'categorie' => $evenement->getCategories()->getSlug(),
                'slug' => $evenement->getSlug(),
                'id' => $evenement->getId()
            ]);
        }


        # return new Response("<html><body><h1>PAGE ARTICLE : $id</h1></body></html>");
        return $this->render('evenement/afficheEvenement.html.twig', [
            'evenement' => $evenement
        ]);
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
     * @Route("/{slug<[a-zA-Z0-9\-_\/]+>}_{id<\d+>}.html",
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
}


