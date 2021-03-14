<?php

namespace App\Form;

use App\Entity\StockIn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
                DateTimeType::class,
                [
                    'date_label'=>'Select Date',
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label'=>'Download CSV',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StockIn::class,
            'date' => new \DateTime(),
        ]);
    }
}
