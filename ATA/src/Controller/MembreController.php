<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 09/01/2019
 * Time: 11:13
 */

namespace App\Controller;


use App\Entity\Membre;
use App\Form\MembreFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MembreController extends AbstractController
{
    /**
     * @Route("/inscription.html",
     *     name="membre_inscription")
     * @param Request $request
     * @return Response
     */
    public function inscription(Request $request,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        # Création d'un utilisateur
        $membre = new Membre();
        $membre->setRoles(['ROLE_ADHERANT']);

        #Création du formulaire MembreFormType
        $form = $this->createForm(MembreFormType::class,$membre)
                    ->handleRequest($request);

        # Soumission du formulaire
        if($form->isSubmitted() && $form->isValid()){
            # Encodage du mot de passe
            $membre->setPassword($passwordEncoder->encodePassword($membre,$membre->getPassword()));

            # Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();

            # Notification
            $this->addFlash('notice',
                'Félicitation, vous pouvez maintenant vous connecter !');

            # Redirection
            return $this->redirectToRoute('index');
        }

        # Affichage dans la vue
        return $this->render('membre/inscription.html.twig',[
                'form' => $form->createView()
        ]);
    }

    /**
     * Formulaire pour éditer un membre
     * @Route("/editer-un-membre/{id<\d+>}.html", name="membre_edit")
     * @param Membre $membre
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editMembre(Membre $membre, Request $request)
    {
        # Création du formulaire avec les information de la BDD
        $form = $this->createForm(MembreFormType::class,$membre)
            ->handleRequest($request);

        # Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()){

            # Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();

            # Notification
            $this->addFlash('notice',
                'Membre modifié');

            # Redirection
            return $this->redirectToRoute('membre',[
                'membre' => $membre
            ]);
        }

        # Affichage dans la vue
        return $this->render('membre/inscription.html.twig',[
            'form' => $form->createView()
        ]);
    }

}