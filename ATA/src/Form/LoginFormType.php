<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 09/01/2019
 * Time: 15:54
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email',EmailType::class,[
            'label' => false,
            'trim' => true,
            'attr' => ['placeholder' => "Email"]
        ])
            ->add('password',PasswordType::class,[
                'label' => false,
                'attr' => ['placeholder' => "Mot de passe"]
            ])
            ->add('Submit',SubmitType::class,[
                'label' => "Connexion"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        # ici null parce que c'est symfony qui va s'occuper de la connexion
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_login';
    }

}