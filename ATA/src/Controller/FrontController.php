<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 07/01/2019
 * Time: 17:38
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{

    public function index()
    {
        return $this->render('front/index.html.twig');
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
}