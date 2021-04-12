<?php

namespace App\Tests;


use App\Component\Validator\Constraints\ContainBalance;
use App\Component\Validator\Constraints\ContainBalanceValidator;
use Codeception\Module\Asserts;
use App\Entity\StockOut;
use App\Entity\User;
use App\Repository\StockInRepository;
use Codeception\Test\Unit;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\UnexpectedValueException;


class ContainBalanceValidatorTest extends Unit
{
    private ContainBalanceValidator $containBalanceValidator;
    private StockInRepository $stockInRepository;
    private Constraint $constraint;
    private Asserts $assert;
  //  private ExecutionContextInterface $context;

    protected function _setUp()
    {
        $this->stockInRepository = $this->createMock(StockInRepository::class);
        $this->containBalanceValidator = new ContainBalanceValidator($this->stockInRepository);
        //$this->context = $this->createMock(ExecutionContextInterface::class);
        $this->constraint=new ContainBalance();
        $this->assert=$this->createMock(Asserts::class);
    }

    public function testValidationWillReturnTrueIfNoProductSet()
    {

//        $product = $this->createMock(Product::class);
//        $product->method('getId')->willReturn(1);
        $constraint = $this->createMock(ContainBalance::class);
        $stockOut = new StockOut();
//        $stockOut->setQuantity(100);
//        $stockOut->setProduct($product);

      //  $this->stockInRepository->method('getBalance')->willReturn(110);

        $this->assertTrue($this->containBalanceValidator->validate($stockOut, $constraint));


    }


    public function my_callback($a)
    {
        return $a;
    }
    public function testValidateWillReturnExceptionIfNotInstanceOfContainBalance()
    {


        //Want this approach
        $newConstraint =new StockOut();

        $assert=$this->assert;
        $assert->expectThrowable(UnexpectedValueException::class,$this->my_callback($this->containBalanceValidator->validate($newConstraint,$this->constraint)));
      //second Approach
        $this->assertInstanceOf(User::class,$this->constraint);
       // $this->assertTrue($this->containBalanceValidator->validate($newConstraint,$this->constraint));


    }


}
