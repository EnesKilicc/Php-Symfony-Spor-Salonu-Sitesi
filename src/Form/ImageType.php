<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\SporPaket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('image', FileType::class,[
                'label' => 'Paket Main Image',
                'mapped' => false,
                'required' => false,
                'constraints' =>[
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload valid image file',
                    ])
                ],
            ])
            ->add('sporPaket', EntityType::class,[
                'class' => SporPaket::class,
                'choice_label' => 'title',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
            'csrf_protection' => false,
        ]);
    }
}
