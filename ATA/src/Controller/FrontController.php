<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 07/01/2019
 * Time: 17:38
 */

namespace App\Controller;

use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{

    public function index()
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * @Route("/apropos", name="front_apropos")
     * @return Response
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
}