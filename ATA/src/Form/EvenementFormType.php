<?php
/**
 * Created by PhpStorm.
 * User: boussaid
 * Date: 09/01/2019
 * Time: 11:31
 */

namespace App\Form;



use App\Entity\Categorie;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class EvenementFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'label' => false,
                'data_class' => null,
                'placeholder' => 'catégorie'
            ])

            ->add('titre', TextType::class, [
            'label' => "Titre de l'événement",
            'attr' => [
                'placeholder' => "Titre de l'événement"
            ]
             ])

            ->add('contenu', TextareaType::class,[
                    'label' => "Déscription"
            ])

            ->add('dateEvenement', DateTimeType::class, [
                'label' => "Date de l'évenement",
                'format' => "dd-MMM-yyyy",
            ])

            ->add('lieu', TextType::class, [
                'label' => "lieu de l'événement"
            ])

            ->add('featuredImage', FileType::class, [
                'attr' => [
                    'class' => 'dropify'
                ]
            ])

            ->add('prixAdulte', IntegerType::class, [
                'label' => "Prix pour adulte",
                'attr' =>[
                    'placeholder' => "saisissez le prix"
                ]
            ])

            ->add('prixEnfant', IntegerType::class, [
                'label' => "Prix pour enfant",
                'attr' =>[
                    'placeholder' => "saisissez le prix"
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => "créer Evénement"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class
        ]);
    }


}