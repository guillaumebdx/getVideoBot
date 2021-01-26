<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/media", name="media_")
 */
class MediaController extends AbstractController
{
    /**
     * @Route("/last", name="last")
     */
    public function index(MediaRepository $mediaRepository)
    {
        return $this->render('media/index.html.twig', [
            'media' => $mediaRepository->findBy([], ['id' => 'DESC'],10),
        ]);
    }
}
