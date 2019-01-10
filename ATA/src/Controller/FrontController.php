<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 07/01/2019
 * Time: 17:38
 */

namespace App\Controller;

use App\Entity\Evenement;
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
    public function categorieEvenement()
    {
        return $this->render('front/categorie.html.twig');
    }

    /**
     * @Route("/article",name="front_article")
     */
    public function article()
    {
        return $this->render('front/article.html.twig');
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
     * @Route("/categories",
     *     name="front_evenement")
     * @param $id
     * @param $slug
     * @param $categorie
     * @return Response
     */

    public function evenement()

    {
        return $this->render('evenement/afficheEvenement.html.twig');
    }
}


