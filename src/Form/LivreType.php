<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isbn', null, [
                'label' => 'ISBN 13',
                'attr' => ['class' => 'form-control my-2']
            ])
            ->add('titre', null, [
                'attr' => ['class' => 'form-control my-2']
            ])
            ->add('nombre_pages', null, [
                'label' => 'Nombre de pages',
                'attr' => ['class' => 'form-control my-2']
            ])
            ->add('date_de_parution', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control my-2'],
            ])
            ->add('note', null, [
                'attr' => ['class' => 'form-control my-2']
            ])
            ->add('auteurs', null, [
                'attr' => ['class' => 'form-control my-2']
            ])
            ->add('genres', null, [
                'attr' => ['class' => 'form-control my-2']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
