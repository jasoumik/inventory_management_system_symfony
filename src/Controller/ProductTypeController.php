<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductType;
use App\Form\ProductTypeType;
use App\Repository\ProductTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/product/type')]
class ProductTypeController extends AbstractController
{
    #[Route('/list', name: 'product_type_index', methods: ['GET'])]
    public function index(ProductTypeRepository $productTypeRepository): Response
    {
        return $this->render('product_type/index.html.twig', [
            'product_types' => $productTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'product_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $productType = new ProductType();
        $form = $this->createForm(ProductTypeType::class, $productType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productType);
            $entityManager->flush();

            if ($request->isXMLHttpRequest()) {
                return new JsonResponse(['status'=>'success','message'=>'data has been saved Successfully']);
            }

            return $this->redirectToRoute('product_type_index');
        }


//        if($request->isXMLHttpRequest() && !$form->isValid()){
//            $formErrors = $this->getFormErrors($form);
//            return new JsonResponse(
//                [
//                    'status' => 400,
//                    'errors' => $formErrors,
//                    'form' => $form->getName(),
//                ],
//                400
//            );
//        }

        return $this->render('product_type/new.html.twig', [
            'product_type' => $productType,
            'form' => $form->createView(),
        ]);
    }

    private function getFormErrors(FormInterface $form)
    {
        $errors = [];

        // Global
        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }

        // Fields
        foreach ($form as $child/* @var Form $child */) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $errors;
    }

    #[Route('/{id}', name: 'product_type_show', methods: ['GET'])]
    public function show(ProductType $productType): Response
    {
        return $this->render('product_type/show.html.twig', [
            'product_type' => $productType,
        ]);
    }

    #[Route('/{id}/edit', name: 'product_type_edit', methods: ['GET', 'POST'])]
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

    #[Route('/{id}',  name: 'product_type_delete', methods: ['DELETE'])]
    public function delete(Request $request, ProductType $productType, EntityManagerInterface $em): Response
    {

        if ($this->isCsrfTokenValid('delete'.$productType->getId(), $request->request->get('_token'))) {
            $this->getDoctrine()->getRepository(Product::class)->deleteAllProducts($productType->getId());
            $em->remove($productType);
            $em->flush();

        }

        return $this->redirectToRoute('product_type_index');
    }

    #[Route('/delete/{id}', name: 'delete_product_type_ajax', methods: ['POST'])]
    public function deleteProductType(Request $request, ProductType $productType): Response
    {
        //if ($this->isCsrfTokenValid('delete' . $productType->getId(), $request->request->get('_token'))) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($productType);
        $entityManager->flush();
        //}

        return $this->json(['status' => 'success', 'message' => 'Data has been deleted successfully']);
//                return $this->redirectToRoute('product_type_index');

    }




//for new product Type adding

//    #[Route('/newt', name: 'product_type_new_pt', methods: ['POST'])]
//    public function newAjaxRequest(Request $request):Response
//    {
//
//
//        if ($request->isXMLHttpRequest()) {
//            return new JsonResponse(['type'=>'error', 'message'=>'Success']);
//
//        }
//        return new Response('request not submitted!', 400);
//    }





}
