<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="app_profile", methods={"GET"})
     */
    public function profile($id, UserRepository $repo): Response
    {
        $user = $repo->find($id);
        $userInfo = $user->getUserInfo();
        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
            'user'=>$user,
            'infos'=>$userInfo,
        ]);
    }

    
}
