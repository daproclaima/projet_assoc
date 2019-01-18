<?php
/**
 * Created by PhpStorm.
 * User: boussaid
 * Date: 14/01/2019
 * Time: 00:53
 */

namespace App\Form;


use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditeContactFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('adresse', TextType::class, [
        'label' => "Adresse de l'association",
        'attr' => [
            'placeholder' => "Saisissez l'adresse"
        ]
        ])

                ->add('ville', TextType::class, [
            'label' => "Ville",
            'attr' => [
                'placeholder' => "Saisissez la ville"
            ]
            ])

            ->add('codePostal', IntegerType::class, [
                'label' => "Code postal",
                'attr' => [
                    'placeholder' => "Saisissez le code postal"
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => "E-mail",
                'attr' => [
                    'placeholder' => "Saisissez l'adresse e-mail de l'association"
                ]
            ])

            ->add('telephone', TextType::class, [
                'label' => "Téléphone",
                'attr' => [
                    'placeholder' => "saisissez le numero de téléphone de l'association"
                ]
            ])

            ->add('Submit',SubmitType::class,[
                'label' => "Editer mes coordonées"
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'form';
    }

}