<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 09/01/2019
 * Time: 15:52
 */

namespace App\Controller\Security;


use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Connexion d'un membre
     * @Route("/connexion.html",name="security_connexion")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connexion(AuthenticationUtils $authenticationUtils)
    {
        # Récupération du formulaire
        $form = $this->createForm(LoginFormType::class, [
            'email' => $authenticationUtils->getLastUsername()
        ]);

        $error = $authenticationUtils->getLastAuthenticationError();


        # Affichage de la vue
        return $this->render('security/connexion.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }
    /**
     *  Déconnexion d'un membre
     * @Route("/deconnexion.html", name="security_deconnexion")
     */
    public function deconnexion()
    {
    }

}