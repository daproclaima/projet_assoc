<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 10/01/2019
 * Time: 14:55
 */

namespace App\Form;


use App\Entity\Album;
use App\Entity\Photos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalerieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', TextType::class, [
            'label' => "Titre de l'événement",
            'attr' => [
                'placeholder' => "Titre de la photo"
            ]
        ])
                ->add('featuredImage', FileType::class, [
                'attr' => [
                    'class' => 'dropify'
                ]
            ])
                ->add('submit', SubmitType::class, [
                    'label' => "Ajouter une photo"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photos::class
        ]);
    }
        public function getBlockPrefix()
        {
            return 'form';
        }


}