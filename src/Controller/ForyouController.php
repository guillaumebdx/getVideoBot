<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ForyouController extends AbstractController
{
    /**
     * @Route("/foryou", name="foryou")
     */
    public function index(MediaRepository $mediaRepository)
    {
        return $this->render('foryou/index.html.twig', [
            'media' => $mediaRepository->findBy(['type' => 'video'], ['id' => 'DESC'], 50),
        ]);
    }
}
