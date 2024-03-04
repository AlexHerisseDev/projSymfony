<?php

namespace App\Controller;

use App\Entity\Games;
use App\Form\GameRegFormType;
use App\Repository\UserRepository;
use App\Repository\GamesRepository;
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
    public function delete( $id, Request $request, UserRepository $repo, EntityManagerInterface $entityManager): Response
    {   
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

    /**
     * @Route("/admin/games", name="app_adminGames")
     */
    public function adminGames(GamesRepository $repo): Response
    {
        $games = $repo->findall();
        return $this->render('admin/adminGames.html.twig', [
            'controller_name' => 'AdminPageController',
            'games'=>$games
        ]);
    }

    /**
     * @Route("/admin/games/Register", name="app_gameRegister")
     */
    public function gameRegister(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = new Games();
        $form = $this->createForm(GameRegFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('app_adminGames');
        }

        return $this->render('admin/gameRegister.html.twig', [
            'GameRegForm' => $form->createView(),
        ]);
    }


}
