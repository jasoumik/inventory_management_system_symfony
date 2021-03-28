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
use Symfony\Component\Validator\Constraints\NotBlank;

class StockOutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (isset($this)) {
            $builder
                ->add('product', EntityType::class, [
                    'class'=>Product::class,
                    'placeholder' => 'Select The Product First',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => ['class' => 'select'],

                ])
                ->add('date',
                    DateType::class,
                    [
                        'widget' => 'single_text',
                        'format' => 'dd/mm/yyyy',
                        'html5' => false,
                        'attr' => [
                            'class' => 'input-datepicker',
                            'placeholder' => 'Select Date',
                            'style' => 'width:100%',
                        ],
                    ])
                ->add('quantity', NumberType::class,
                    [
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ],
                        'attr' => ['class' => 'quantity','id'=>'quantity'],
                    ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StockOut::class,
            'attr' => ['class' => 'form-control mt-2 bg-light',  'style' => 'width:75%'],
        ]);
    }
}
