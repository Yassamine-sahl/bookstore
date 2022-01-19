<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_prenom', null, [
                'label' => 'Nom et Prenom',
                'attr' => ['class' => 'form-control my-2']
            ])
            ->add('sexe', ChoiceType::class, [
                'choices'  => [
                    'Féminin' => 'f',
                    'Masculin' => 'm',
                ],
                'attr' => ['class' => 'form-control my-2']
            ])
            ->add('date_de_naissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control my-2'],
            ])
            ->add('nationalite', null, ['attr' => ['class' => 'form-control my-2']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
