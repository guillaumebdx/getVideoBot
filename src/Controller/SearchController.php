<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/pseudo", name="search")
     */
    public function index(Request $request)
    {
        $pseudo = $request->get('pseudo');
        return $this->redirectToRoute('media_user', ['username' => $pseudo ? $pseudo : ' ']);
    }
}
