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
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
* @Route("product-list", name="product_list_")
*/

class ProductsController extends AbstractController
{
    /**
     * @Route("", name="products")
     */

    public function index()
    {
        $data = new StockIn();
        $formView = $this->createForm(
            StockType::class, $data,
            [
                'action' => $this->generateUrl('product_list_view')
            ])->createView();

        return $this->render(
            'products/index.html.twig',
            [
                'form' => $formView
            ]);

    }

    /**
     * @Route("/stocks", name="view" methods={"POST"})
     */
    public function stockView(Request $request, StockInRepository $stockInRepository)
    {
        $stockIn = new StockIn();
        $form = $this->createForm(StockType::class, $stockIn);
        $form->handleRequest($request);
        if ($form->isSubmitted() && !$form->isValid()) {
            throw new BadRequestHttpException('Invalid request');
        }
        $date = $stockIn->getDate();
        $data = $this->getDoctrine()->getRepository(StockIn::class)->getProducts($date);

        return $this->render('products/index.html.twig',
           array('products' => $data));


    }



}