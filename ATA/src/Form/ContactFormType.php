<?php
/**
 * Created by PhpStorm.
 * User: boussaid
 * Date: 16/01/2019
 * Time: 16:02
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom",
                'attr' => [
                    'placeholder' => "Saisissez votre nom"
                ]
            ])

            ->add('prenom', TextType::class, [
                'label' => "Prénom",
                'attr' => [
                    'placeholder' => "Saisissez votre prénom"
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => "E-mail",
                'attr' => [
                    'placeholder' => "Saisissez votre e-mail"
                ]
            ])
            ->add('objet', TextType::class, [
                'label' => "Objet",
                'attr' => [
                    'placeholder' => "l'objet de votre contact"
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => "Message",
                'attr' => [
                    'placeholder' => "Votre message"
                ]
            ])
            ->add('Submit',SubmitType::class,[
                'label' => "Envoyer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', null);
    }


    public function getBlockPrefix()
    {
        return 'form';
    }
}