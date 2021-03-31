<?php

namespace App\Controller;

use App\Entity\StockIn;
use App\Form\StockInType;
use App\Repository\StockInRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stock/in')]
class StockInController extends AbstractController
{
    #[Route('/', name: 'stock_in_index', methods: ['GET'])]
    public function index(StockInRepository $stockInRepository): Response
    {
        return $this->render('stock_in/index.html.twig', [
            'stock_ins' => $stockInRepository->findAll(),
        ]);
    }

    #[Route('/aggrid', name: 'stock_in_grid', methods: ['GET'])]
    public function grid(StockInRepository $stockInRepository): Response
    {
        $product = [];
        $newProduct = $stockInRepository->findAll();
        foreach ($newProduct as $row) {
            $product [] = ['id' => $row->getId(),
                'name' => $row->getProduct()->getName(),
                'date' => $row->getDate()->format('d-m-Y'),
                'quantity' => $row->getQuantity()];
        }
        return $this->json($product);
    }

    #[Route('/new', name: 'stock_in_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $stockIn = new StockIn();
        $form = $this->createForm(StockInType::class, $stockIn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stockIn);
            $entityManager->flush();

            return $this->redirectToRoute('stock_in_index');
        }

        return $this->render('stock_in/new.html.twig', [
            'stock_in' => $stockIn,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'stock_in_show', methods: ['GET'])]
    public function show(StockIn $stockIn): Response
    {
        return $this->render('stock_in/show.html.twig', [
            'stock_in' => $stockIn,
        ]);
    }

    #[Route('/{id}/edit', name: 'stock_in_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StockIn $stockIn): Response
    {
        $form = $this->createForm(StockInType::class, $stockIn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stock_in_index');
        }

        return $this->render('stock_in/edit.html.twig', [
            'stock_in' => $stockIn,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'stock_in_delete', methods: ['DELETE'])]
    public function delete(Request $request, StockIn $stockIn): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stockIn->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stockIn);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stock_in_index');
    }
}
