<?php

namespace App\Controller;

use App\Entity\Duel;
use App\Entity\Player;
use App\Form\DuelType;
use App\Service\Ranking;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $players = $this->getDoctrine()->getRepository(Player::class)->findBy([], ['rank' => 'DESC']);
        $duels = $this->getDoctrine()->getRepository(Duel::class)->findBy([], ['created_at' => 'DESC'], 10);

        $duel = new Duel();
        $formDuel = $this->createForm(DuelType::class, $duel);
        $formDuel->handleRequest($request);

        if ($formDuel->isSubmitted() && $formDuel->isValid()) {
            $scoreA = Ranking::DRAW;
            $scoreB = Ranking::DRAW;

            if ($duel->getScoreA() > $duel->getScoreB()) {
                $scoreA = Ranking::WIN;
                $scoreB = Ranking::LOST;
            } elseif ($duel->getScoreB() > $duel->getScoreA()) {
                $scoreA = Ranking::LOST;
                $scoreB = Ranking::WIN;
            }

            // Ranking
            $ranking = $this->get('App\Service\Ranking')->setNewSettings(
                $duel->getPlayerA()->getRank(),
                $duel->getPlayerB()->getRank(),
                $scoreA,
                $scoreB
            );
            $duel->getPlayerA()->setRank($ranking['ratingA']);
            $duel->setRankA($ranking['diffA']);
            $duel->getPlayerB()->setRank($ranking['ratingB']);
            $duel->setRankB($ranking['diffB']);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($duel);
            $em->flush();

            // Prevent refresh
            return $this->redirectToRoute('index');
        }

        return $this->render('default/index.html.twig', [
            'players' => $players,
            'duels' => $duels,
            'formDuel' => $formDuel->createView()
        ]);
    }
}