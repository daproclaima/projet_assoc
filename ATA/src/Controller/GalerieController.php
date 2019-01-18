<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 10/01/2019
 * Time: 15:18
 */

namespace App\Controller;


use App\Entity\Album;
use App\Entity\Photos;
use App\Form\GalerieFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GalerieController extends AbstractController
{
    use HelperTrait;
    /**
     * @Route("/ajouter-des-photos", name="galerie_ajoutPhoto")
     * @param Request $request
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function ajoutPhoto(Request $request)
    {
        # Création d'une d'une photos
        $photos = new Photos();

        # Création du Formulaire
        $form = $this->createForm(GalerieFormType::class, $photos)
            ->handleRequest($request);

        # Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            $featuredImage = $photos->getFeaturedImage();

            $fileName = $this->slugify($photos->getTitre())
                . '.' . $featuredImage->guessExtension();

            try {
                $featuredImage->move(
                    $this->getParameter('photos_assets_dir'),
                    $fileName
                );
            } catch (FileException $e) {

            }
            # Modification du nom de l'image
            $photos->setFeaturedImage($fileName);

            # Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($photos);
            $em->flush();

            # NOTIFICATION
            $this->addFlash('notice',
                'Photo ajouté avec succès !');

            # Redirection
            return $this->redirectToRoute('galerie_ajoutPhoto');

        }

        # Affichage dans la vue
        return $this->render('galerie/formGalerie.html.twig', [
            'form' => $form->createView()
        ]);
    }
}