<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/deleteUser/{id}", name="app_delete", methods={"GET","POST"})
     */
    public function deleteUser( $id, Request $request, UserRepository $repo, EntityManagerInterface $entityManager): Response
    {   
        $user = $repo->find($id);
        $userInfo = $user->getUserInfo();
        $entityManager->remove($userInfo);
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('notice', 'Successfully deleted');

        return $this->redirectToRoute("home");

        return $this->render('index.html.twig', [
        ]);
    }

    /**
     * @Route("/addTutor/{id}",  name="app_addTutor", methods={"GET","POST"})
     */
    public function addTutor($id, Request $request, UserRepository $repo, EntityManagerInterface $entityManager): Response{
        $user = $repo->find($id);$user->setRoles( array('ROLE_TEACHER'));
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute("home");

        return $this->render('index.html.twig', [
            'controller_name' => 'AdminPageController',
        ]);
    }
    
}
