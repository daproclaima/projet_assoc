<?php
/**
 * Created by PhpStorm.
 * User: SNITPRO
 * Date: 09/01/2019
 * Time: 12:02
 */

namespace App\Form;


use App\Controller\HelperTrait;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{

    use HelperTrait;
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $builder


            ->add('titre', TextType::class, [
                'required' => true,
                'label'    => "Titre de l'article",
                'attr'     => [
                    'placeholder' => "Titre de l'Article"
                ]
            ])
            #contenu
            ->add('contenu', TextareaType::class, [
                'required' => true,
                'label'    => "Contenu de l'article",
            ])
            #Featuredimage
            ->add('featuredimage', FileType::class, [
                'attr'     => [
                    'class' => 'dropify'
                ]
            ])

            #Spotlight
            ->add('spotlight', CheckboxType::class, [
                'required' => false,

                'attr'     => [
                    'data-toggle' => 'toggle',
                    'data-on'     => 'Oui',
                    'data-off'    => 'Non',
                    ]
            ])
            #Submit
            ->add('submit', SubmitType::class, [
                'label'    => "Publier mon article",

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'form';
    }

}