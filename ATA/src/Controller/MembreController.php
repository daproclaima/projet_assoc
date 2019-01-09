<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 09/01/2019
 * Time: 11:13
 */

namespace App\Controller;


use App\Entity\Membre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MembreController extends AbstractController
{
    public function inscription(Request $request)
    {
        # Création d'un utilisateur
        $membre = new Membre();
        $membre->setRoles(['ROLE_ADHERANT']);

    }

}