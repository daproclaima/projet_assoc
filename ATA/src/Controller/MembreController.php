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
     * @Route("membre.html",
     *     name="membre_liste")
     */
    public function membre()
    {
        # Récupération de la listes des membres
        $membres = $this->getDoctrine()
            ->getRepository(Membre::class)
            ->findAll();
        $nbrMembres = count($membres);

        # Affichage dans la vue
        return $this->render('membre/membre.html.twig',[
            'membres' => $membres,
            'nbrMembres' => $nbrMembres
        ]);
    }
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
            return $this->redirectToRoute('security_connexion');
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
        # Création du formulaire avec les informations de la BDD
        $form = $this->createForm(MembreFormType::class,$membre)
            ->handleRequest($request);

        $password = $membre->getPassword();
        dump($password);
        # Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()){
            $membre->setPassword($password);
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

    /**
     * @Route("/supprimer-un-membre/{id<\d+>}.html", name="membre_supprimer")
     */
    public function suppMembre(Membre $membre)
    {
        # Suppression du membre en BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($membre);
        $em->flush();

        return $this->redirectToRoute("membre_liste");
    }

    /**
     * @Route("/reset_password/{token}", name="membre_reset_password")
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();
            // Récupération de l'utilisateur correspondant au token présent dans l'url
            $membre = $entityManager->getRepository(Membre::class)->findOneByResetToken($token);
            /* @var $membre Membre */

            if ($membre === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('index');
            }

            // Reset du token et nouveau mot de passe
            $membre[0]->setResetToken(null);
            $membre[0]->setPassword($passwordEncoder->encodePassword($membre[0], $request->request->get('password')));
            $entityManager->flush();

            $this->addFlash('notice', 'Mot de passe mis à jour');

            return $this->redirectToRoute('security_connexion');
        }else {

            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }

    }
}