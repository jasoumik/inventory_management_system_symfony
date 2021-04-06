<?php

namespace App\Controller;


use App\Entity\Product;
use App\Entity\ProductType;

use App\Form\ProductTypeType;
use App\Repository\AuditLogRepository;
use App\Repository\ProductTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



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


//
//            $user = $user->getUsername();
//
//            $audit= new AuditLog();
//
//            $date = new DateTime(date('Y-m-d H:i:s'));
//
//            $audit->setDate($date);
//            $audit->setUserName($user);
//            $em=$this->getDoctrine()->getManager();
//            $em->persist($audit);
//            $em->flush();

            return $this->redirectToRoute('product_type_index');
        }

        return $this->render('product_type/new.html.twig', [
            'product_type' => $productType,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'product_type_show', methods: ['GET'])]
    public function show(ProductType $productType): Response
    {
        return $this->render('product_type/show.html.twig', [
            'product_type' => $productType,
        ]);
    }

//    #[Route('/audit/log', name: 'log', methods: ['GET'])]
//    public function grid(AuditLogRepository $auditLogRepository): Response
//    {
//        $log = [];
//        $auditLog = $auditLogRepository->findAll();
//        foreach ($auditLog as $row) {
//            $log [] = [
//                'type' => $row->getType(),
//                'desc'=>$row->getDescription(),
//                'date'=>$row->getEventTime()->format("F j, Y"),
//            ];
//        }
//        return $this->json(
//            $log
//        );
//    }

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


}
