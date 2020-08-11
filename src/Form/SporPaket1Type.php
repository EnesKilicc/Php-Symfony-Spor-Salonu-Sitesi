<?php

namespace App\Form;

use App\Entity\SporPaket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SporPaket1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('image')
            ->add('Trainer')
            ->add('Saat')
            ->add('days')
            ->add('kisisayisi')
            ->add('fiyat')
            ->add('status')
            ->add('detail')
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SporPaket::class,
        ]);
    }
}
