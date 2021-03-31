<?php

namespace App\Form;

use App\Entity\StockIn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CsvDownloadFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'date',
                DateType::class,
                [
                    'placeholder' => 'Select Date',
                    'widget' => 'single_text',

                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Download CSV',
                    'attr' => ['class' => 'form-control mt-2 btn-info',  'style' => 'width:75%'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StockIn::class,

        ]);
    }
}
