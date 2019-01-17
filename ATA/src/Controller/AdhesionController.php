<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 17/01/2019
 * Time: 10:08
 */

namespace App\Controller;


use App\Entity\Membre;
use App\Entity\Paiement;
use App\Form\AdhesionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdhesionController extends AbstractController
{

    /**
     * @Route("/paiement/{id<\d+>}.html",name="adhesion_paiement")
     * @param Membre $membre
     * @param Request $request
     * @param Paiement $paiement
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adhesionPaiement(Membre $membre,Request $request)
    {
        $unMembre = $this->getDoctrine()->getRepository(Membre::class)->findById();

        $paiement= new Paiement();

        # Création du formulaire
        $form = $this->createForm(AdhesionFormType::class,$paiement)
            ->handleRequest($request);

        # Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            $paiement->setMembre($membre);

            $membre->setRoles(['ROLE_ADHERANT']);
            # Sauvegadre en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($paiement);
            $em->flush();

        }

        #affichage dans la vue
        return $this->render('membre/paiementAdhesion.html.twig', [
            'form' => $form->createView(),
            'membre'=> $unMembre
        ]);
    }
}