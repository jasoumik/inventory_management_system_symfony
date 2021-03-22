<?php


namespace App\Controller;

use App\Entity\StockIn;
use App\Form\StockReportType;
use App\Repository\StockInRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products", name="product_list_")
 */
class ProductsController extends AbstractController
{
    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index():Response
    {
        $form = $this->createForm(
            StockReportType::class, null, [
            'action' => $this->generateUrl('product_list_view')
        ]);
        return $this->render(
            'products/index.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/reports", name="view", methods={"POST"})
     */
    public function stockView(Request $request, StockInRepository $stockInRepository):Response
    {
        $stockIn = new StockIn();
        $form = $this->createForm(StockReportType::class, $stockIn);
        $form->handleRequest($request);
        if ($form->isSubmitted() && !$form->isValid()) {
            throw new BadRequestHttpException('Form isn\'t submitted');
        }
        $date = $stockIn->getDate();
        $products = $stockInRepository->getProductWiseBalance($date);
        return $this->newView($products, $date);
    }

    public function newView(array $data, $date): Response
    {
        return $this->render('products/view.html.twig', [
            'products' => $data,
            'date' => $date
        ]);
    }


}