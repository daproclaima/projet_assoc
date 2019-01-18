<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 16/01/2019
 * Time: 19:13
 */

namespace App\Form;


use App\Entity\Paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AdhesionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePaiement', DateTimeType::class, [
                'label' => "Date de paiement",
                'format' => "dd-MMM-yyyy",
            ])

            ->add('modePaiement',ChoiceType::class,[
            'placeholder' => 'Moyen de paiement',
            'choices' => [
                'Cheque' => 'cheque',
                'Virement' => 'virement',
                'Espèce' => 'espece',
                'Autres' => 'autres'
                ]
            ])

            ->add('montant', IntegerType::class, [
                'label' => "Montant",
            ])
            
            ->add('Submit',SubmitType::class,[
                'label' => "Envoyer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class
        ]);
    }
    public function getBlockPrefix()
    {
        return 'form';
    }

}