<?php

namespace App\Form\Admin;

use App\Entity\Admin\Purchase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userid')
            ->add('paketid')
            ->add('name')
            ->add('surname')
            ->add('email')
            ->add('phone')
            ->add('duration')
            ->add('total')
            ->add('ip')
            ->add('note')
            ->add('status', ChoiceType::class,[
                'choices'=>[
                    'New' => 'New',
                    'Accepted'=> 'Accepted',
                    'Rejected' => 'Rejected',
                    'Completed'=>'Completed',
                ]
            ])
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class,
        ]);
    }
}
