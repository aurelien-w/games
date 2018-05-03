<?php

namespace App\Controller;


use App\Entity\PlayerSeasonData;
use App\Entity\Season;
use App\Entity\SeasonDuel;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Fuck PSR-2 ! ;)
 * 
 * @package 
 */
class SeasonController extends Controller {

    /**
     * @Route("/saisons", name="season_index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('season/index.html.twig', [
            'seasons'        => $this->getDoctrine()->getRepository('App:Season')->findBy([], ['startAt' => 'DESC']),
            'current_season' => $this->getDoctrine()->getRepository('App:Season')->findOneBy(['status' => Season::STATUS_IN_PROGRESS]),
            'players'        => $this->getDoctrine()->getRepository('App:Player')->findAll()
        ]);
    }

    /**
     * @Route("/saisons/{id}", requirements={ "id" : "\d+" }, name="season_show")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        return $this->render('season/show.html.twig', [
            'current_season' => $this->getDoctrine()->getRepository('App:Season')->find($id)
        ]);
    }

    /**
     * @Route("/saisons/nouveau", name="season_create")
     *
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function create(TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();

        $lastCreatedSeason = $em->getRepository('App:Season')->findOneBy([], ['startAt' => 'DESC']);
        $today = Carbon::now();

        if (
            null === $lastCreatedSeason ||
            $today->greaterThan($lastCreatedSeason->getFinishAt()) ||
            $today->format('m') === $lastCreatedSeason->getStartAt()->format('m')
        )
        {
            $season = new Season();

            $start = $today;

            if (
                null !== $lastCreatedSeason &&
                $today->format('m') === $lastCreatedSeason->getStartAt()->format('m')
            )
            {
                $start->addMonth();
            }

            $start->day = 1;
            $start->setTime(0,0, 0, 0);
            $season->setStartAt($start);

            $finish = clone $start;
            $finish->endOfMonth();
            $finish->setTime(23,59, 59);
            $season->setFinishAt($finish);

            $em->persist($season);
            $em->flush();

            $this->addFlash('success', "La saison du mois de ".$translator->trans($start->format('F'))." a été ajoutée.");
        } else {
            $this->addFlash('danger', "Vous ne pouvez pas ajouter d'autres saisons pour le moment.");
        }

        return $this->redirectToRoute('season_index');
    }

    /**
     * @Route("/saison/inscription", name="season_player_register")
     *
     * @param Request             $request
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function registerPlayer(Request $request, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();

        $season = $em->getRepository('App:Season')->find($request->query->get('season'));
        $player = $em->getRepository('App:Player')->find($request->query->get('player'));

        if (!$season->hasPlayer($player)) {
            $playerSeasonData = new PlayerSeasonData();
            $playerSeasonData->setSeason($season);
            $playerSeasonData->setPlayer($player);
            $em->persist($playerSeasonData);

            foreach ($season->getPlayerSeasonData() as $seasonDatum) {
                for ($i = 0; $i < 2; $i++) {
                    $seasonDuel = new SeasonDuel();
                    $seasonDuel->setSeason($season);

                    if ($i % 2 === 0) {
                        $seasonDuel->setPlayerSeasonDataA($playerSeasonData);
                        $seasonDuel->setPlayerSeasonDataB($seasonDatum);
                    } else {
                        $seasonDuel->setPlayerSeasonDataA($seasonDatum);
                        $seasonDuel->setPlayerSeasonDataB($playerSeasonData);
                    }

                    $em->persist($seasonDuel);
                }
            }

            $em->flush();

            $this->addFlash('success', 'Vous êtes maintenant inscrit à la saison : ' . $translator->trans($season->getStartAt()->format('F')));
        } else {
            $this->addFlash('danger', 'Vous êtes déjà inscrit à cette saison.');
        }


        return $this->redirectToRoute('season_index');
    }

    /**
     * @Route("/saisons/commencer/{id}", requirements={ "id" : "\d+" }, name="season_start")
     *
     * @param TranslatorInterface $translator
     * @param                     $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function startSeason(TranslatorInterface $translator, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $season = $em->getRepository('App:Season')->find($id);

        $today = new \DateTime();

        if ($today->format('m') === $season->getStartAt()->format('m')) {
            $season->setStatus(Season::STATUS_IN_PROGRESS);
            $em->persist($season);
            $em->flush();
            $this->addFlash('success', 'La saison ' . $translator->trans($season->getStartAt()->format('F')) . ' a commencé.');
        } else {
            $this->addFlash('danger', 'Cette saison ne peut pas commencer.');
        }

        return $this->redirectToRoute('season_index');
    }

    /**
     * @Route("/saisons/matches/score/{id}", requirements={ "id" : "\d+" }, name="season_save_duel_score")
     *
     * @param Request $request
     * @param         $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function saveScore(Request $request, $id)
    {
        if ("" !== $request->query->get('score-a') && "" !== $request->query->get('score-b')) {
            $em = $this->getDoctrine()->getManager();

            $duel = $em->getRepository('App:SeasonDuel')->find($id);

            $duel->setScoreA($request->query->get('score-a'));
            $duel->setScoreB($request->query->get('score-b'));

            $em->persist($duel);

            $playerA = $duel->getPlayerSeasonDataA();
            $playerB = $duel->getPlayerSeasonDataB();

            $playerA->setDuelPlayed($playerA->getDuelPlayed() + 1);
            $playerB->setDuelPlayed($playerB->getDuelPlayed() + 1);

            if ((int) $request->query->get('score-a') > (int) $request->query->get('score-b')) {
                $playerA->setDuelWin($playerA->getDuelWin() + 1);
                $playerA->setRank($playerA->getRank() + 3);
                $playerB->setDuelLoose($playerB->getDuelLoose() + 1);
            } elseif ((int) $request->query->get('score-a') < (int) $request->query->get('score-b')) {
                $playerA->setDuelLoose($playerA->getDuelLoose() + 1);
                $playerB->setDuelWin($playerB->getDuelWin() + 1);
                $playerB->setRank($playerB->getRank() + 3);
            } else {
                $playerA->setDuelNull($playerA->getDuelNull() + 1);
                $playerA->setRank($playerA->getRank() + 1);
                $playerB->setDuelNull($playerB->getDuelNull() + 1);
                $playerB->setRank($playerB->getRank() + 1);
            }

            $em->persist($playerA);
            $em->persist($playerB);

            $em->flush();

            $this->addFlash('success', 'Les scores ont été enregistrés');
        } else {
            $this->addFlash('danger', 'Les scores n\'ont pas pu être enregistrés');
        }

        return $this->redirectToRoute('season_index');
    }

    /**
     * @Route("/saisons/terminer/{id}", requirements={ "id" : "\d+" }, name="season_end")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function endSeason($id)
    {
        $em = $this->getDoctrine()->getManager();

        $season = $em->getRepository('App:Season')->find($id);

        $season->setStatus(Season::STATUS_COMPLETED);

        $em->persist($season);
        $em->flush();

        return $this->redirectToRoute('season_index');
    }
}