<?php

namespace App\Controller;

use App\Entity\ProductType;
use App\Entity\StockIn;
use App\Entity\User;
use App\Form\DashboardType;
use App\Repository\ProductTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminDashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
    #[Route('/admin/dashboard/register', name: 'admin_dashboard_reg')]
    public function register(Request $request, UserPasswordEncoderInterface $passEncoder)
    {
        $user=new User();

        $em=$this->getDoctrine()->getManager();
        $form=$this->createForm(DashboardType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $passEncoder->encodePassword($user, $user->getPassword())
            );
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('product_type_index');
        }
        return $this->render('admin_dashboard/new_user.html.twig',[

            'form' => $form->createView()
        ]);
    }

    #[Route('/list', name: 'list')]
    public function chart():Response
    {
//        $list=$this->getDoctrine()->getRepository(ProductType::class)->countTypes();
//        $stockIn=$this->getDoctrine()->getRepository(StockIn::class)->stockInDateWise();
        $stockInDate=$this->getDoctrine()->getRepository(StockIn::class)->stockInDate();
        $stockInQuantity=$this->getDoctrine()->getRepository(StockIn::class)->stockInQuantity();
        $highestStockIn=$this->getDoctrine()->getRepository(StockIn::class)->highest5Quantity();
        $lowestStockIn=$this->getDoctrine()->getRepository(StockIn::class)->lowest5Quantity();
                return $this->json( [
//                    'list'=>$list,
//                    'stock'=>$stockIn,
                    'stock_date'=>$stockInDate,
                    'stock_qty'=>$stockInQuantity,
                    'high'=>$highestStockIn,
                    'low'=>$lowestStockIn
                ]);

    }
}
