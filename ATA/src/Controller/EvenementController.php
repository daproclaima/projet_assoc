<?php
/**
 * Created by PhpStorm.
 * User: boussaid
 * Date: 09/01/2019
 * Time: 12:19
 */

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    use HelperTrait;
    /**
     * @Route("/creer-un-evenement", name="creation_evenement")
     */
    public function newEvenement(Request $request)
    {

        # Création d'un nouvel Evenement
        $evenement = new Evenement();

        # Création du Formulaire
        $form = $this->createForm(EvenementFormType::class, $evenement)
            ->handleRequest($request);

        # Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            #1. traitement de l'upload de l'image. Documentation : https://symfony.com/doc/current/controller/upload_file.html
            // $file stores the uploaded PDF file

            $featuredImage = $evenement->getFeaturedImage();
            if (null !== $featuredImage) {

                /** @var UploadedFile $featuredImage */
                $featuredImage = $evenement->getFeaturedImage();
                $fileName = $this->slugify($evenement->getTitre()) . '.' . $featuredImage->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $featuredImage->move(
                        $this->getParameter('evenement_assets_dir'),
                        $fileName
                    );

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochure' property to store the PDF file name
                // instead of its contents


                # Sauvegadre en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($evenement);
                $em->flush();

                # NOTIFICATION
                $this->addFlash('notice',
                    'Félicitations, votre Evénement est en ligne !');

                # REDIRECTION
                return $this->redirectToRoute('evenement_afficheEvenement', [], Response::HTTP_MOVED_PERMANENTLY);
            }

        }


        #affichage dans la vue
        return $this->render('evenement/formEvenement.html.twig', [
            'form' => $form->createView()
        ]);

    }
}