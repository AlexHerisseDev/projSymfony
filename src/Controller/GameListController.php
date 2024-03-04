<?php

namespace App\Controller;

use App\Repository\GamesRepository;
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
     * @Route("/store/{id}", name="app_storePage")
     */
    public function storePage($id, GamesRepository $repo): Response
    {
        $game = $repo->find($id);
        return $this->render('game_list/gamePage.html.twig', [
            'controller_name' => 'GameListController',
            'game'=>$game
        ]);
    }
}
