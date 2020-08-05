<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\SporPaket;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use phpDocumentor\Reflection\Type;
use PhpParser\Node\Scalar\MagicConst\File as Files;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SporPaketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'title',
                ])
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('image', FileType::class,[
                'label' => 'Hotel Main Image',
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
            ->add('Trainer', ChoiceType::class,[
                'choices' =>    [
                    'Ahmet Efe' => 'Ahmet Efe',
                    'Ayşe Kaya' => 'Ayşe Kaya',
                    'Enes Kılıç' => 'Enes Kılıç',
                    'Nazlı Demir' => 'Nazlı Demir'
                ],
            ])
            ->add('Saat')
            ->add('days')
            ->add('kisisayisi', ChoiceType::class,[
                'choices' =>    [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4'
                ],
            ])
            ->add('fiyat')
            ->add('detail',CKEditorType::class, array(
                'config' => array(
                    'uicolor' => '#ffffff',
                ),
            ))
            ->add('status', ChoiceType::class,[
                'choices' => [
                    'True' => 'True',
                    'False' => 'False'
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SporPaket::class,
        ]);
    }
}
