<?php


namespace App\Form;

namespace App\Form;

use App\Entity\StockIn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'date',
                DateType::class,
                [
                    'class'=>StockIn::class,
                    'label'=>'Select Date'
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                     'label'=>'Submit'
                ]
            );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => StockIn::class,
                'attr' => [
                    'id' => 'product-list-form',

                ]
            ]
        );
    }
}