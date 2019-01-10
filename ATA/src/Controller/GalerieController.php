<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 10/01/2019
 * Time: 15:18
 */

namespace App\Controller;


use App\Entity\Photos;
use App\Form\GalerieFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GalerieController extends AbstractController
{

    /**
     * @Route("/ajouter-des-photos", name="galerie_ajoutPhoto")
     * @param Request $request
     */
    public function ajoutPhoto(Request $request)
    {
        # Création d'une collection de photos
        $photos = new Photos();


        # Création du Formulaire
        $form = $this->createForm(GalerieFormType::class, $photos)
            ->handleRequest($request);


        # Affichage dans la vue
        return $this->render('galerie/formGalerie.html.twig', [
            'form' => $form->createView()
        ]);
    }
}