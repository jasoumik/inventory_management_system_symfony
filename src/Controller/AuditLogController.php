<?php

namespace App\Controller;

use App\Repository\AuditLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
  *
  * @IsGranted("ROLE_ADMIN")
  */
class AuditLogController extends AbstractController
{
    #[Route('/logger', name: 'logger')]
    public function index(): Response
    {
        return $this->render('logger/index.html.twig', [
            'controller_name' => 'LoggerController',
        ]);
    }


    #[Route('/audit/log', name: 'log', methods: ['GET'])]
    public function grid(AuditLogRepository $auditLogRepository): Response
    {
        $log = [];
        $auditLog = $auditLogRepository->findAll();
        foreach ($auditLog as $row) {
            $date=$row->getEventTime();
            $log [] = [
                'type' => $row->getType(),
                'desc'=>$row->getDescription(),
                'date'=>$date->format("F j, Y"),
            ];
        }
        return $this->json(
            $log
        );
    }
}
