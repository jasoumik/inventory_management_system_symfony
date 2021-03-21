<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\StockOut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockOutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('quantity', NumberType::class)
            ->add('product', EntityType::class, [
                'class'=>Product::class
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StockOut::class,
            'attr' => ['class' => 'form-control mt-2 bg-light',  'style' => 'width:75%'],
        ]);
    }
}
