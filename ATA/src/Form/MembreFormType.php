<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 09/01/2019
 * Time: 11:28
 */

namespace App\Form;


use App\Entity\Membre;
use App\Membre\Listener\MembrePasswordFieldSubscriber;
use App\Membre\MembreRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('prenom',TextType::class,[
                'label' => 'Prénom',
                'attr' => ['placeholder' => "Votre prénom"]
            ])

            ->add('nom',TextType::class,[
                'label' => 'Nom',
                'attr' => ['placeholder' => "Votre nom"]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => "jean.dupond@xxx.fr"]
            ])

            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',

                'attr' => ['placeholder' => "Mot de passe"]
            ])

            ->add('telephone',TextType::class,[
                'label' => 'Téléphone',
                'attr' => ['placeholder' => "0123456789"]
            ])

            ->add('adresse',TextType::class,[
                'label' => 'Adresse',
                'attr' => ['placeholder' => "1, rue de la république"]

            ])

            ->add('codePostal',TextType::class,[
                'label' => 'Code Postal',
                'attr' => ['placeholder' => "75000"]
            ])

            ->add('ville',TextType::class,[
                'label' => 'Ville',
                'attr' => ['placeholder' => "Paris"]
            ])

            ->add('Submit',SubmitType::class,[
                'label' => "Je m'inscris"
            ])

            ->addEventSubscriber(new MembrePasswordFieldSubscriber())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       # On dit au formulaire qu'il va recevoir des données de type MembreRequest

       $resolver->setDefaults([
           'data_class' => MembreRequest::class
       ]);
    }

}