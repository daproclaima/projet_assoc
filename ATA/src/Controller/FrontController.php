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

    /**
     * Matches /blog exactly
     *
     * @Route("/accueil", name="accueil")
     */

    public function index()
    {
        return $this->render('front/index.html.twig');
    }


    /**
     * Matches /blog exactly
     *
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('front/contact.html.twig');
    }
}