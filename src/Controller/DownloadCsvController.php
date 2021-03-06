<?php

namespace App\Controller;

use App\Entity\StockIn;
use App\Form\CsvDownloadFormType;
use App\Form\StockReportType;
use App\Repository\StockInRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
     * @return Response
     */
    public function index(): Response
    {
        $form = $this->createForm(
            CsvDownloadFormType::class,
            null,
            ['action' => $this->generateUrl('download_csv_download')]
        );
        return $this->render('download_csv/index.html.twig', [

            'form' => $form->createView()
        ]);
    }

    protected function downloadAsCSV(array $data, string $fileName): Response
    {
        $fp = fopen('php://output', 'w');
        $header = ['Name', 'Type', 'Stock In', 'Stock Out', 'Balance'];
        fputcsv($fp, $header, ',');
        foreach ($data as $row) {
            //$row['date']=$row['date']->format('d-m-Y');
           $row['balance']=$row['stockin']-$row['stockout'];


            fputcsv($fp, $row, ',');
        }
        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $fileName . '');
        return $response;
    }

    /**
     * @Route("/download", name="download")
     * @param Request $request
     * @return Response
     */
    public function download(Request $request): Response
    {
        $stockIn = new StockIn();
        $form = $this->createForm(CsvDownloadFormType::class, $stockIn);
        $form->handleRequest($request);
        if ($form->isSubmitted() && !$form->isValid()) {
            throw new BadRequestHttpException('Form isn\'t submitted');
        }
        $date = $stockIn->getDate();


        $data = $this->getDoctrine()->getRepository(StockIn::class)->getProductWiseBalance($date,$date);
        $fileName = 'stock-report-' . $date->format('d-m-Y') . '.csv';
        return $this->downloadAsCSV($data, $fileName);
    }
}
