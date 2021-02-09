<?php

namespace App\Controller;

use App\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DebugController extends AbstractController
{
    /**
     * @Route("/debug/tweet/{id}", name="debug")
     */
    public function index($id, MessageService $messageService)
    {
        $messageService->ddById($id);
        return $this->render('debug/index.html.twig', [
            'controller_name' => 'DebugController',
        ]);
    }
}
