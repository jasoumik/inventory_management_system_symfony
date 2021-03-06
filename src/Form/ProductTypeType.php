<?php

namespace App\Form;

use App\Entity\ProductType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',TextType::class,[
            'label' => 'Product Type',
                'required'=>false,
                'constraints' => [
                    new NotBlank(),
                ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductType::class,
            'attr' => ['class' => 'form-control mt-2 bg-light',  'style' => 'width:75%'],
            'csrf_protection' => false,
        ]);
    }
}


