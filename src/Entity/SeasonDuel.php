<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeasonDuelRepository")
 */
class SeasonDuel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Season
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="duels")
     */
    private $season;

    /**
     * @var PlayerSeasonData
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\PlayerSeasonData", inversedBy="duelsA")
     */
    private $playerSeasonDataA;

    /**
     * @var PlayerSeasonData
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\PlayerSeasonData", inversedBy="duelsB")
     */
    private $playerSeasonDataB;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $scoreA;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $scoreB;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return Season
     */
    public function getSeason(): Season
    {
        return $this->season;
    }

    /**
     * @param Season $season
     */
    public function setSeason(Season $season): void
    {
        $this->season = $season;
    }

    /**
     * @return PlayerSeasonData
     */
    public function getPlayerSeasonDataA(): PlayerSeasonData
    {
        return $this->playerSeasonDataA;
    }

    /**
     * @param PlayerSeasonData $playerSeasonDataA
     */
    public function setPlayerSeasonDataA(PlayerSeasonData $playerSeasonDataA): void
    {
        $this->playerSeasonDataA = $playerSeasonDataA;
    }

    /**
     * @return PlayerSeasonData
     */
    public function getPlayerSeasonDataB(): PlayerSeasonData
    {
        return $this->playerSeasonDataB;
    }

    /**
     * @param PlayerSeasonData $playerSeasonDataB
     */
    public function setPlayerSeasonDataB(PlayerSeasonData $playerSeasonDataB): void
    {
        $this->playerSeasonDataB = $playerSeasonDataB;
    }

    /**
     * @return int
     */
    public function getScoreA()
    {
        return $this->scoreA;
    }

    /**
     * @param int $scoreA
     */
    public function setScoreA(int $scoreA): void
    {
        $this->scoreA = $scoreA;
    }

    /**
     * @return int
     */
    public function getScoreB()
    {
        return $this->scoreB;
    }

    /**
     * @param int $scoreB
     */
    public function setScoreB(int $scoreB): void
    {
        $this->scoreB = $scoreB;
    }
}
