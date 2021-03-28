<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\StockIn;
use App\Entity\StockOut;
use App\Form\StockOutType;
use App\Repository\StockOutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stock/out')]
class StockOutController extends AbstractController
{
    #[Route('/', name: 'stock_out_index', methods: ['GET'])]
    public function index(StockOutRepository $stockOutRepository): Response
    {
        return $this->render('stock_out/index.html.twig', [
            'stock_outs' => $stockOutRepository->findAll(),
        ]);
    }

    #[Route('/aggrid', name: 'stock_out_grid', methods: ['GET'])]
    public function grid(StockOutRepository $stockOutRepository):Response
    {
        $stocks = [];
        $stock = $stockOutRepository->findAll();
        foreach ($stock as $row) {
            $stocks[] = ['id' => $row->getId(),
                    'name' => $row->getProduct()->getName(),
                    'date' => $row->getDate(),
                    'quantity'=>$row->getQuantity()];
        }
        return $this->json($stocks);
    }

    #[Route('/new', name: 'stock_out_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $stockOut = new StockOut();
        dump($request->request->all());
        //  $product= new Product();
        $form = $this->createForm(StockOutType::class, $stockOut);
        $form->handleRequest($request);
        // $id=$this->getDoctrine()->getRepository(Product::class)->find();
        //   $productId=$stockOut->getProduct()->getId();
        // var_dump($id);

        //$stockOutQuantity=$stockOut->getQuantity();

        // $stockInQuantity=$this->getDoctrine()->getRepository(StockIn::class)->getBalance($productId);
        if ($form->isSubmitted() && $form->isValid()) {
//            $productId=$stockOut->getProduct()->getId();
//          //   var_dump($productId);
//
//            $stockOutQuantity=$stockOut->getQuantity();
//
//            $stockInQuantity=$this->getDoctrine()->getRepository(StockIn::class)->getBalance($productId);
//            if ($stockOutQuantity<$stockInQuantity){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stockOut);
            $entityManager->flush();


            return $this->redirectToRoute('stock_out_index');
//            }else{
//               // throw new BadRequestHttpException('Form isn\'t submitted');
//                return $this->render('stock_out/error.html.twig');
//            }

        }

        return $this->render('stock_out/new.html.twig', [
            'stock_out' => $stockOut,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'stock_out_show', methods: ['GET'])]
    public function show(StockOut $stockOut): Response
    {
        return $this->render('stock_out/show.html.twig', [
            'stock_out' => $stockOut,
        ]);
    }

    #[Route('/{id}/edit', name: 'stock_out_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StockOut $stockOut): Response
    {
        $form = $this->createForm(StockOutType::class, $stockOut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stock_out_index');
        }

        return $this->render('stock_out/edit.html.twig', [
            'stock_out' => $stockOut,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'stock_out_delete', methods: ['DELETE'])]
    public function delete(Request $request, StockOut $stockOut): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stockOut->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stockOut);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stock_out_index');
    }

    #[Route('/balance/{id}', name: 'balance')]
    public function balance($id): Response
    {
        //  return
        $balance = $this->getDoctrine()->getRepository(StockIn::class)->getBalance($id);

        return $this->json([

            'balance' => $balance
        ]);
    }
}
