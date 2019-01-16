<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 09/01/2019
 * Time: 15:52
 */

namespace App\Controller\Security;

use App\Entity\Membre;
use App\Form\LoginFormType;
use Exception;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
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
     * @Route("/mot-de-passe-oublie", name="security_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param Swift_Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @return Response
     */
    public function oubliePassword(Request $request,
                                   UserPasswordEncoderInterface $encoder,
                                   Swift_Mailer $mailer,
                                   TokenGeneratorInterface $tokenGenerator
    ): Response
    {

        if ($request->isMethod('POST')) {
            /** @var Membre $membre */
            // Récupération du membre par rapoort au mail
            $email = $request->request->get('email');
            $entityManager = $this->getDoctrine()->getManager();
            $membre = $entityManager->getRepository(Membre::class)->findOneByEmail($email);

            if ($membre === null) {
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('index');
            }
            // Génération d'un token
            $token = $tokenGenerator->generateToken();
            // Ecriture du token lié à l'utilisateur correspondant à l'adresse mail
            try{
                $membre[0]->setResetToken($token);
                $entityManager->flush();
            } catch (Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('index');
            }
            // Génération de l'url avec le token qui correspond
            $url = $this->generateUrl('membre_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            // Envoie du mail avec l'url contenant le token
            $message = (new Swift_Message('Mot de passe oublié'))
                ->setFrom('test.ATA@test.fr')
                ->setTo($membre[0]->getEmail())
                ->setBody(
                    "Voici le token pour réinitialisé votre mot de passe : " . $url,
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('notice', 'Mail envoyé');

            return $this->redirectToRoute('security_password');
        }

        return $this->render('security/oubliePassword.html.twig');
    }
    /**
     *  Déconnexion d'un membre
     * @Route("/deconnexion.html", name="security_deconnexion")
     */
    public function deconnexion()
    {
    }

}