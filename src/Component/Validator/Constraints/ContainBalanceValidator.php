<?php

/*
 * This file is part of the sbiCloud Budget module.
 *
 * Copyright (c) 2019-2022, BRAC IT SERVICES LIMITED <http://www.bracits.com>
 */

namespace App\Component\Validator\Constraints;


use App\Entity\StockOut;
use App\Repository\StockInRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainBalanceValidator extends ConstraintValidator
{


    /**
     * @var StockInRepository
     */
    private StockInRepository $stockInRepository;


    public function __construct(StockInRepository $stockInRepository )
    {

        $this->stockInRepository = $stockInRepository;

    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
       // dump($value->getProduct());
        if (!$constraint instanceof ContainBalance) {
            throw new UnexpectedValueException($value, ContainBalance::CLASS_CONSTRAINT);
        }
       if($value->getProduct()==null){
           return true;
       }
        $productId=$value->getProduct()->getId();

        $balance = $this->stockInRepository->getBalance($productId);
        if ($value->getQuantity() > $balance) {
            $this->context->buildViolation(
                'This value should be smaller than '.$balance
            )
                ->atPath('quantity')
                ->addViolation();

            return false;
        }
        return true;

    }


}
