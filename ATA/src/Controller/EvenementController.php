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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    use HelperTrait;
    /**
     * @Route("/creer-un-evenement", name="creation_evenement")
     * @Security("has_role('ROLE_ADMIN')")
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

                # Mise à jour de l'image'
                $evenement->setFeaturedImage($fileName);

                # Mise à jour du slug
                $evenement->setSlug($this->slugify($evenement->getTitre()));

                # Sauvegadre en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($evenement);
                $em->flush();

                # NOTIFICATION
                $this->addFlash('notice',
                    'Félicitations, votre Evénement est en ligne !');

                # REDIRECTION
                return $this->redirectToRoute('front_evenement', [
                    'categorie' => $evenement->getCategories()->getSlug(),
                    'slug' => $evenement->getSlug(),
                    'id' => $evenement->getId()
                ], Response::HTTP_MOVED_PERMANENTLY);
            }
        }


        #affichage dans la vue
        return $this->render('evenement/formEvenement.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * Formulaire Pour editer un Evenement
     * @Route("/editer-un-evenemnt/{id<\d+>}",
     *     name="evenement_edit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editEvenement(Evenement $evenement, Request $request)
    {

        # on récupére l'image de l'evenement
        $featuredImageName = $evenement->getFeaturedImage();

        /**
         * notre formulaire attend une instance de file pour l'édition de la featured image
         */
        $evenement->setFeaturedImage(
            new File($this->getParameter('evenement_assets_dir').'/'.$evenement->getFeaturedImage())
        );

        # Création du Formulaire
        $form = $this->createForm(EvenementFormType::class, $evenement)
            ->handleRequest($request);


        # Traitment des données POST
        #$form->handleRequest($request);

        # Si le formulaire est soumis et valide
        if($form->isSubmitted() && $form->isValid()){
            # dump ($evenement);
            #1. traitement de l'upload de l'image. Documentation : https://symfony.com/doc/current/controller/upload_file.html
            // $file stores the uploaded PDF file

            $featuredImage = $evenement->getFeaturedImage();
            if(null !== $featuredImage) {

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

                # Mise à jour de l'image'
                $evenement->setFeaturedImage($fileName);
            }else {
                $evenement->setFeaturedImage($featuredImageName);
            }

            # Mise à jour du slug
            $evenement->setSlug($this->slugify($evenement->getTitre()));


            # Sauvegadre en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            # NOTIFICATION
            $this->addFlash('notice',
                'Félicitations, votre evenement a été édité !');

            # REDIRECTION
            return $this->redirectToRoute('front_evenement', [
                'categorie' => $evenement->getCategories()->getSlug(),
                'slug' => $evenement->getSlug(),
                'id' => $evenement->getId()
            ]);

        }

        #affichage dans la vue
        return $this->render('evenement/formEvenement.html.twig', [
            'form' => $form->createView()
        ]);


    }


    /**
     * @param Evenement $evenement
     * @Route("/supprimer-un-evenement/{id<\d+>}",
     *     name="evenement_delete")
     * @return
     * @Security("has_role('ROLE_ADMIN')")
     */
    
    # suppression d'un evenement en BDD
    public function deleteEvenement(Evenement $evenement){
        $em = $this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();


        # REDIRECTION
        return $this->redirectToRoute('front_categorie_evenements', [
            'categorie' => $evenement->getCategories()->getSlug(),
            'slug' => $evenement->getSlug(),
            'id' => $evenement->getId()
        ]);

    }
}
