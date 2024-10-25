<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPageController extends AbstractController
{
    /**
     * @Route("/admin", name="app_adminPage")
     */
    public function adminPage(UserRepository $repo): Response
    {
        $users = $repo->findall();
        return $this->render('admin/adminPage.html.twig', [
            'controller_name' => 'AdminPageController',
            'users'=>$users
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_delete", methods={"GET","POST"})
     */
    public function delete( $id, UserRepository $repo, EntityManagerInterface $entityManager): Response
    {   
        //This function gets the user from its ID and then deletes it from the userInfo then user tables
        $user = $repo->find($id);
        $userInfo = $user->getUserInfo();
        $entityManager->remove($userInfo);
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('notice', 'Successfully deleted');

        return $this->redirectToRoute("app_admin_page");

        return $this->render('admin/adminPage.html.twig', [
            'controller_name' => 'AdminPageController',
        ]);
    }



}
