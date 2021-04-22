<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\StockIn;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class StockInType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class'=>Product::class,
                'placeholder' => 'Select The Product First',
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => ['class' => 'form-group  mb-2'],
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-group mb-2'],
            ])
            ->add('quantity', NumberType::class,
            [
                'attr' => ['class' => 'form-group mb-2'],
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StockIn::class,
            'attr' => ['class' => 'bg-dark form-inline',  'style' => 'width:75%'],
        ]);
    }
}
