<?php


namespace App\Tests;


use App\Entity\ProductType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;
class ProductTypeTest extends KernelTestCase
{

    public function product_type_should_be_created()
    {
        $type=new ProductType();
        $type->setType('sobji');
       $em=$this->getDoctrine()->getManager();
        $em->persist($type);
        $em-> flush();
  }
}