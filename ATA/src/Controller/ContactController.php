<?php
/**
 * Created by PhpStorm.
 * User: SNITPRO
 * Date: 08/01/2019
 * Time: 10:26
 */

namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/ajouter-mes-coordonees",
     *     name="ccoordonees_ajout")
     * @param Request $request
     * @return Response
     */
    public function inscription(Request $request)
    {
        # Création d'un utilisateur
        $contact = new Contact();

        #Création du formulaire MembreFormType
        $form = $this->createForm(ContactFormType::class,$contact)
            ->handleRequest($request);

        # Soumission du formulaire
        if($form->isSubmitted() && $form->isValid()){

            # Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            # Notification
            $this->addFlash('notice',
                'Félicitation, vos contacts ont été crées!');

            # Redirection
            return $this->redirectToRoute('front_contact');
        }

        # Affichage dans la vue
        return $this->render('contact/formContact.html.twig',[
            'form' => $form->createView()
        ]);
    }
}