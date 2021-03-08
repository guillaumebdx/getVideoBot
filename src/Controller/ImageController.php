<?php

namespace App\Controller;

use App\Service\Image\Color;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/image/index", name="image")
     */
    public function index(Color $color)
    {
        $img = $color->sepia('https://www.photo-up.fr/public/Medias/3-seances/photo_famille/vignettes/vignette_brochette_1.jpg');

        return $this->render('image/index.html.twig', [
            'img' => $img,
        ]);
    }
}
