<?php

namespace App\Controller;

use App\Entity\StockIn;
use App\Form\CsvDownloadFormType;
use App\Repository\StockInRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
    /**
     * @Route("/download/csv", name="download_csv_")
     */
class DownloadCsvController extends AbstractController
{

//    public function __construct(
//        StockInRepository $stockRepo
//    ) {
//        $this->stockRepo = $stockRepo;
//
//    }
    /**
     * @Route("/", name="download_csv")
     */
    public function index(Request $request): Response
    {
//      $stockRepo=new StockInRepository;
//      $stock= $stockRepo->getQueryforCSV();

       // $stock=$this->getDoctrine()->getRepository(StockIn::class)->getQueryForCSV($date);

        $form = $this->createForm(

            CsvDownloadFormType::class,
            null,
         ['action' => $this->generateUrl('download_csv_download'),
             'method'=>'GET']
        );
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $data=$form->getData();
        }
        return $this->render('download_csv/index.html.twig', [
            'controller_name' => 'DownloadCsvController',
          //  'query'=>$stock,
            'form' => $form->createView()
        ]);
    }
//    /**
//     * @Route("", name="index", methods={"GET"})
//     */
//    public function index(): Response
//    {
//        $downloadUrl = '';
//
//            $downloadUrl = $this->generateUrl('download_csv_download');
//
//
//        return $this->render( $downloadUrl);
//    }
    protected function downloadAsCSV(array $data, string $fileName)
    {

                $fp = fopen('php://output', 'w');

                foreach ($data as $row) {

                  // dd($row);
                    fputcsv($fp, $row,',');
                }
                $response = new Response();
                $response->headers->set('Content-Type', 'text/csv');
                $response->headers->set('Content-Disposition', 'attachment; filename='.$fileName.'');
        return $response;
    }
    /**
     * @Route("/download", name="download")
     */
    public function download(EntityManagerInterface $entityManager ,CsvDownloadFormType $form)
    {
      // $date= $form->get('date')->getData();

       $date='2020-10-11 00:00:00' ;
        $data =$entityManager->getRepository(StockIn::class)->getQueryForCSV($date);
        $header = ['Name', 'Type','Quantity','Date'];
        array_unshift($data, $header);
//        // var_dump($data);
        return $this->downloadAsCSV($data, ''.$date.'.csv');
    }
}
