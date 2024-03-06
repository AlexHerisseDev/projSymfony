<?php

namespace App\Controller;

use App\Repository\GamesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameListController extends AbstractController
{
    /**
     * @Route("/store", name="app_store")
     */
    public function store(GamesRepository $repo): Response
    {
        $games = $repo->findall();
        
        return $this->render('game_list/store.html.twig', [
            'controller_name' => 'GameListController',
            'games'=>$games
        ]);
    }

    /**
     * @Route("/store/{id}", name="app_storePaginated")
     */
    public function storePaginated($id, GamesRepository $repo): Response
    {
        $games = $repo->findall();
        $nbGames = count($games);
        $nbPages=(int) ($nbGames/8);

        return $this->render('game_list/storePaginated.html.twig', [
            'controller_name' => 'GameListController',
            'games'=>$games,
            'page'=>$id,
            'nbGames'=>$nbGames,
            'nbPages'=>$nbPages,
        ]);
    }

    /**
     * @Route("/store/game/{id}", name="app_storePage")
     */
    public function storePage($id, GamesRepository $repo): Response
    {
        $game = $repo->find($id);
        return $this->render('game_list/storePage.html.twig', [
            'controller_name' => 'GameListController',
            'game'=>$game
        ]);
    }

    /**
     * @Route("/store/game/{id}/add", name="app_addGameToUser")
     */
    public function addGameToUser($id, GamesRepository $repo, EntityManagerInterface $entityManager): Response
    {
        $game = $repo->find($id);
        $game->addUser($this->getUser());

        $entityManager->persist($game);
        $entityManager->flush();

        return $this->redirectToRoute('app_storePage',  ['id'=>$id]);

        return $this->render('game_list/storePage.html.twig', [
            'controller_name' => 'GameListController',
        ]);
    }

}
