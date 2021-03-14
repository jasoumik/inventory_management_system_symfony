<?php


namespace App\Controller;

use App\Entity\NewProject\Budget;
use App\Entity\Product;
use App\Entity\StockIn;
use App\Form\FormValidationException;
use App\Form\NewProjectBudgetType;
use App\Form\ProductsType;
use App\Form\StockType;
use App\Repository\StockInRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="product_list")
     * @Method ({"GET"})
     */

    public function index(StockInRepository $stockInRepository){

        $products = $this->getDoctrine()
                        ->getRepository(StockIn::class)
                        ->getProducts();

        return $this->render('products/index.html.twig',
            array('products'=>$products));
    }

    /**
     * @Route("/stocks", name="stock_list")
     * @Method ({GET})
     */

//    public function stockView(Request $request){
//        $stocks = new StockIn();
//        $form = $this->createForm(StockType::class, $stocks);
//        $form->handleRequest($request);
//        if ($form->isSubmitted()) {
//            if (!$form->isValid()) {
//                throw new FormValidationException($form);
//            }
//            $em = $this->get('doctrine')->getManager();
//            $em->persist($stocks);
//            $em->flush();
//        }
//    }


}