<?php

namespace App\Controller;

use App\Entity\ProductType;
use App\Form\ProductTypeType;
use App\Repository\ProductTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product/type")
 */
class ProductTypeController extends AbstractController
{
    /**
     * @Route("/", name="product_type_index", methods={"GET"})
     */
    public function index(ProductTypeRepository $productTypeRepository): Response
    {
        return $this->render('product_type/index.html.twig', [
            'product_types' => $productTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productType = new ProductType();
        $form = $this->createForm(ProductTypeType::class, $productType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productType);
            $entityManager->flush();

            return $this->redirectToRoute('product_type_index');
        }

        return $this->render('product_type/new.html.twig', [
            'product_type' => $productType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_type_show", methods={"GET"})
     */
    public function show(ProductType $productType): Response
    {
        return $this->render('product_type/show.html.twig', [
            'product_type' => $productType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductType $productType): Response
    {
        $form = $this->createForm(ProductTypeType::class, $productType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_type_index');
        }

        return $this->render('product_type/edit.html.twig', [
            'product_type' => $productType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductType $productType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_type_index');
    }
}
