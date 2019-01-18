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
use Symfony\Component\Asset\Packages;
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
        $form = $this->createForm(EvenementFormType::class, $evenement, ['validation_groups' => ['registration']])
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
                $this->addFlash('notice-evenement',
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
     * @param Evenement $evenement
     * @param Request $request
     * @param Packages $packages
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editEvenement(Evenement $evenement, Request $request, Packages $packages)
    {

        # On récupère l'image de l'article
        $featuredImageName = $evenement->getFeaturedImage();

        /**
         * Notre formulaire attend une instance de File
         * pour l'edition de la featuredImage.
         */
        $evenement->setFeaturedImage(
            new File($this->getParameter('evenement_assets_dir')
                . '/' . $featuredImageName)
        );

        # Création du Formulaire + # Traitement des données POST
        $form = $this->createForm(EvenementFormType::class, $evenement,[
            'image_url' => $packages->getUrl('images/product/' . $featuredImageName),
            'validation_groups' => ['update']
        ])
            ->handleRequest($request);

        # Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

             #dump($evenement); die;
            # 1. Traitement de l'upload de l'image

            $featuredImage = $evenement->getFeaturedImage();

            if (null !== $featuredImage) {
                /** @var UploadedFile $featuredImage */
                $featuredImage = $evenement->getFeaturedImage();

                $fileName = $this->slugify($evenement->getTitre())
                    . '.' . $featuredImage->guessExtension();

                try {
                    $featuredImage->move(
                        $this->getParameter('evenement_assets_dir'),
                        $fileName
                    );
                } catch (FileException $e) {

                }

                # Mise à jour de l'image
                $evenement->setFeaturedImage($fileName);
            } else {
                $evenement->setFeaturedImage($featuredImageName);
            }

            # Mise à jour du Slug
            $evenement->setSlug($this->slugify($evenement->getTitre()));

            # Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            # NOTIFICATION
            $this->addFlash('notice-evenement',
                'Félicitations, l\'évenement a bien été édité !');

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
    public function deleteEvenement(Evenement $evenement)
    {
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
