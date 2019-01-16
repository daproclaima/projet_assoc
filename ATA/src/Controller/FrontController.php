<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 07/01/2019
 * Time: 17:38
 */

namespace App\Controller;

use App\Contact\ContactezNous;
use App\Entity\Contact;
use App\Entity\Categorie;
use App\Entity\Evenement;
use App\Entity\Article;
use App\Entity\Photos;
use App\Form\ContactFormType;
use App\Repository\ArticleRepository;
use http\Env\Request;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FrontController extends AbstractController
{

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('front/index.html.twig');
    }



    /**
     * @Route("/galerie",name="front_galerie")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function galerie()
    {
        $photos = $this->getDoctrine()
            ->getRepository(Photos::class)
            ->findByDate();
        return $this->render('front/galerie.html.twig',[
            'photos' => $photos
        ]);
    }



    ##################################### CONTROLLERS HOCINE  ################################################

    /**
     *
     * @Route("/contact", name="front_contact")
     * @param Swift_Mailer $mailer
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function contact(Swift_Mailer $mailer,Request $request)
    {
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->find(1);

        #Création du formulaire ContactFormType
        $form = $this->createForm(ContactFormType::class)
            ->handleRequest($request);


        # Soumission du formulaire
        if($form->isSubmitted() && $form->isValid()){

            $data =$form->getData();
            dump($data);
            $objet = $data['objet'];

            // Envoie du mail contact
            $message = (new Swift_Message($objet))
                ->setFrom($data['email'])
                ->setTo('amazoul.france2018@gmail.com')
                ->setBody(
                    $data['message'],
                    'text/html'
                );

                $mailer->send($message);


            # Notification
            $this->addFlash('notice',
                'Félicitation, votre message à bien été envoyé!');

            # Redirection
            return $this->redirectToRoute('front_contact');
        }

        #Rendu de la vue
        return $this->render('front/contact.html.twig', [
            'contacts' => $contacts,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/adhesion")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adhesion()
    {
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->find(1);

        return $this->render('front/adhesion.html.twig', [
            'contacts' => $contacts
        ]);
    }


    /**
     * @Route("/evenements",name="front_categories")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toutesCategories()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        # on récupere tous les Evenements par ordre de date décroissant
        $evenement = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->findByDate();

        return $this->render('front/categorie.html.twig', [
            'categories'=> $categories,
            'evenement'=> $evenement
        ]);
    }


    /**
     * @Route("/evenements/{slug<[a-zA-Z0-9-/]+>}", name="front_categorie_evenements")
     * @param $categorie
     * @param Evenement|null $evenement
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function evenementsParCategorie($slug, Categorie $categories= null){

        if(null === $categories){
            return $this->redirectToRoute('front_categories',[],Response::HTTP_MOVED_PERMANENTLY);
        }

        $cats = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('evenement/evenementsParCategorie.html.twig',[
            'categories' => $categories,
            'evenement' => $categories->getEvenements(),
            'cats' => $cats
        ]);

    }


    /**
     * @Route("evenement/{categorie<[a-zA-Z0-9-/]+>}/{slug<[a-zA-Z0-9-/]+>}-{id<\d+>}",
     *     name="front_evenement")
     * @param $categorie
     * @param $slug
     * @param Evenement|null $evenement
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function evenement( $categorie, $slug, Evenement $evenement = null)

    {


        if (null === $evenement) {
            return $this->redirectToRoute('front_categorie_evenements', [], Response::HTTP_MOVED_PERMANENTLY);
        }

        #Verification du SLUG
        if ($evenement->getSlug() !== $slug || $evenement->getCategories()->getSlug() !== $categorie) {
            return $this->redirectToRoute('front_evenement', [
                'slug' => $evenement->getSlug(),
                'id' => $evenement->getId()
            ]);
        }

        return $this->render('evenement/evenement.html.twig', [
            'evenement' => $evenement
        ]);

    }


    ######################### FIN CONTROLEURS HOCINE #######################################################


    /**
     * Affiche LES articles
     * @Route("/articles",name="front_les_articles" )
     */
    public function lesArticles()
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();


        return $this->render('front/lesArticles.html.twig', [
            'article' => $article
        ]);


    }

    /**
     * Affiche UN article
     * @Route("/{slug<[a-zA-Z0-9\-_\/]+>}_{id<\d+>}.html",
     *     name="front_article")
     *
     * @param Article $article
     * @param $slug
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
//
    public function article($slug, article $article = null) // par défaut vaut null
    {
//        #####################################
//               REQUETE TEST DE RECUP

//        $article = $this->getDoctrine()
//            ->getRepository(Article::class)
//            ->find(5);
//
//        return $this->render('front/article.html.twig',
//            [    'article' => $article ]);
//        #####################################

        #on s'assure que l'article ne soit pas existant
        if(null === $article){

            return $this->redirectToRoute('index',[],\Symfony\Component\HttpFoundation\Response::HTTP_MOVED_PERMANENTLY);
        }

        #verification du SLUG
        if($article->getSlug() !== $slug){
            return $this->redirectToRoute('front/article.html.twig',[
                'slug'      => $article->getSlug(),
                'id'        => $article->getId()
            ]);

        }

        return $this->render('front/article.html.twig',[
            'article' => $article
        ]);

    }


    /**
     * @Route("/apropos", name="front_apropos")
     *
     */
    public function apropos()
    {
        return $this->render('front/apropos.html.twig');
    }

    /**
     * @Route("/profil/{id<\d+>}.html", name="front_profil")
     * @return Response
     */
    public function profil()
    {
        $membre = $this->getUser();
        return $this->render('membre/profil.html.twig',[
            'membre' => $membre
        ]);
    }


    public function sidebar()
    {
        # Récupération des photos pour la sidebar
        $photos = $this->getDoctrine()
            ->getRepository(Photos::class)
            ->dernieresPhotos();

        #Récuperation du Repository
        $repository = $this->getDoctrine()
            ->getRepository(Evenement::class);

        # Récupérer le 3 derniers évènements
        $evenements = $repository->findLatestEvenements();



        #Récuperation du Repository d' Article
        $repoArticle = $this->getDoctrine()
            ->getRepository(Article::class);

        # Récupérer les 5 derniers articles
        $articles = $repoArticle->findLatestArticles();
    


        #Récuperation du Repository de Contact
        $repoContact = $this->getDoctrine()
            ->getRepository(Contact::class);
        

        # Récupération des coordonnées de contact de l'entreprise
        $contact = $repoContact->find(1);


        #Rendu de la vue
        return $this->render('component/_sidebar.html.twig', [
            'evenements' => $evenements,
            'photos' => $photos,
            'articles' => $articles,
            'contact' => $contact
        ]);
    }

    public function sliderAccueil()
    {
        #Récuperation du Repository
        $repository = $this->getDoctrine()
            ->getRepository(Evenement::class);
        # Récupérer le 3 derniers évènements
        $evenements = $repository->findLatestEvenements();

        #Rendu de la vue
        return $this->render('component/_sliderAccueil.html.twig', [
            'evenements' => $evenements
        ]);
    }


}


