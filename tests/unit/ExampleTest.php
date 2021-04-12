<?php
namespace App\Tests;


use App\Component\Validator\Constraints\ContainBalance;
use App\Component\Validator\Constraints\ContainBalanceValidator;
use App\Entity\User;

use App\Repository\StockInRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Routing;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use App\Simplex\Framework;
use Symfony\Component\Validator\Constraint;

class ExampleTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

//    // tests
    public function testFailure()
    {
//        $this->assertFalse(true);
        $user= new User();
        $user = $user->setEmail('jasoumik@gmail.com');

        $this->assertEquals('jasoumik@gmail.com', $user->getEmail());
    }
    public function testFailure1()
    {
        $this->assertDirectoryExists('src/Controller');
    }
    function testUserNameCanBeChanged()
    {
        // create a user from framework, user will be deleted after the test
        $id = $this->tester->haveInRepository(User::class, ['name' => 'miles','email'=>'hello','password'=>'hello',]);
        // get entity manager by accessing module
        $em = $this->getModule('Doctrine2')->em;
        // get real user
        $user = $em->find(User::class, $id);
        $user->setName('bill');
        $user->setEmail('hello');
        $em->persist($user);
        $em->flush();
        $this->assertEquals('bill', $user->getName());
        // verify data was saved using framework methods
       // $this->tester->seeInRepository(User::class, ['name' => 'bill']);
     //   $this->tester->dontSeeInRepository(User::class, ['name' => 'miles']);
    }

// -
}