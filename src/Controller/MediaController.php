<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use App\Repository\TwitterUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class MediaController extends AbstractController
{
    /**
     * @Route("/media/last", name="media_last")
     */
    public function index(MediaRepository $mediaRepository)
    {
        return $this->render('media/index.html.twig', [
            'media' => $mediaRepository->findBy([], ['id' => 'DESC'],12),
            'by_user' => false,
        ]);
    }

    /**
     * @Route("/{username}", name="media_user")
     */
    public function byUser(string $username,
                           MediaRepository $mediaRepository,
                           TwitterUserRepository $twitterUserRepository)
    {
        $twitterUser = $twitterUserRepository->findOneBy(['username' => $username]);
        return $this->render('media/index.html.twig', [
            'media' => $mediaRepository->findBy(['twitterUser' => $twitterUser], ['id' => 'DESC']),
            'by_user' => true,
        ]);
    }
}
