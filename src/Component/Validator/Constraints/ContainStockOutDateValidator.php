<?php


namespace App\Component\Validator\Constraints;


use App\Repository\StockOutRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainStockOutDateValidator extends ConstraintValidator
{
    /**
     * @var StockOutRepository
     */
    private StockOutRepository $stockOutRepository;


    public function __construct(StockOutRepository $stockOutRepository)
    {

        $this->stockOutRepository = $stockOutRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function validate( $value, Constraint $constraint)
    {
       // dump($value->getDate());
        if (!$constraint instanceof ContainStockOutDate) {
            throw new UnexpectedValueException($value, ContainStockOutDate::CLASS_CONSTRAINT);
        }
        if ($value->getProduct() == null) {
            return true;
        }
        if ($value->getDate() == null) {
            return true;
        }
        $productId = $value->getProduct()->getId();

        $stockInDate = $this->stockOutRepository->getStockInDate($productId);
        if ($value->getDate()->format('Y-m-d H:i:s') < $stockInDate) {
            $this->context->buildViolation(
                'This value should be Greater than '.$stockInDate
            )
                ->atPath('date')
                ->addViolation();

            return false;
        }
    }
}