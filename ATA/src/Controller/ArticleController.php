<?php
/**
 * Created by PhpStorm.
 * User: SNITPRO
 * Date: 09/01/2019
 * Time: 12:53
 */

namespace App\Controller;


use App\ArticleFormType;
use App\Entity\Article;
use App\Entity\Membre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{

    use HelperTrait;


    /**
     * Formulaire pour ajouter un Article
     * @Route("/creer-un-article", name="nouvel_article")
     */
    public function newArticle(Request $request)
    {
//      # Récupération d'un Membre
        $membre = $this->getDoctrine()
            ->getRepository(Membre::class)
            ->find(1);


        # Création d'un Nouvel Article
        $article = new Article();
        $article->setMembre($membre);
//        $article->setMembre($this->getUser());


        # Création du Formulaire +  Traitement des données POST
        $form = $this->createForm(\App\Form\ArticleFormType::class, $article)
            ->handleRequest($request);

        # Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

//            dump($article);
            # 1. Traitement de l'upload de l'image

            /** @var  UploadedFile $featuredImage */
            $featuredImage = $article->getFeaturedImage();

            $fileName = $this->slugify($article->getTitre())
                . '.' . $featuredImage->guessExtension();

            try {
                $featuredImage->move(
                    $this->getParameter('articles_assets_dir'),
                    $fileName
                );
            } catch (FileException $e) {

            }

            # Mise à jour de l'image
            $article->setFeaturedImage($fileName);

            # Mise à jour du Slug
            $article->setSlug($this->slugify($article->getTitre()));


            # Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            # Notification
            $this->addFlash('notice',
                'Félicitations, votre article est en ligne !');

            # Redirection
            return $this->redirectToRoute('front_article', [
                'slug' => $article->getSlug(),
                'id' => $article->getId()
            ]);
        }

        # Affichage dans la vue
        return $this->render('article/ajouterarticle.html.twig', [
            'form' => $form->createView()
        ]);
    }
}