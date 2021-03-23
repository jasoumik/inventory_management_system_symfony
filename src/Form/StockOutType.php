<?php

namespace App\Form;
use App\Controller\StockOutController;
use App\Repository\StockInRepository;
use Doctrine\Persistence;
use App\Entity\Product;
use App\Entity\StockIn;
use App\Entity\StockOut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

class StockOutType extends AbstractType
{


    /**
     * @var StockInRepository
     */
    private StockInRepository $repository;

    public function __construct(StockInRepository $repository){


        $this->repository = $repository;
    }
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
                ->add('date', DateType::class, [
                    'widget' => 'single_text',
                ])
                ->add('quantity', NumberType::class,
                [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                       ],
                    'attr' => ['class' => 'msg'],
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
