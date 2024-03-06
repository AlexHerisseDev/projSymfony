<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LibraryController extends AbstractController
{
    /**
     * @Route("/library", name="app_library")
     */
    public function index(UserRepository $repo): Response
    {
        $user = $this->getUser();
        return $this->render('library/library.html.twig', [
            'controller_name' => 'LibraryController',
            'user' => $user,
        ]);
    }
}
