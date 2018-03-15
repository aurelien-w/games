<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerSeasonDataRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PlayerSeasonData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $rank = 0;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="playerSeasonData")
     */
    private $player;

    /**
     * @var Season
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="playerSeasonData")
     */
    private $season;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SeasonDuel", mappedBy="playerSeasonDataA")
     */
    private $duelsA;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SeasonDuel", mappedBy="playerSeasonDataB")
     */
    private $duelsB;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    private $duelPlayed;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    private $duelWin;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    private $duelNull;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    private $duelLoose;

    /**
     * PlayerSeasonData constructor.
     */
    public function __construct()
    {
        $this->duelsA = new ArrayCollection();
        $this->duelsB = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->rank       = 0;
        $this->duelPlayed = 0;
        $this->duelWin    = 0;
        $this->duelNull   = 0;
        $this->duelLoose  = 0;
    }

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
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     */
    public function setRank(int $rank): void
    {
        $this->rank = $rank;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer(Player $player): void
    {
        $this->player = $player;
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
     * @return ArrayCollection
     */
    public function getDuelsA(): ArrayCollection
    {
        return $this->duelsA;
    }

    /**
     * @param ArrayCollection $duelsA
     */
    public function setDuelsA(ArrayCollection $duelsA): void
    {
        $this->duelsA = $duelsA;
    }

    /**
     * @return ArrayCollection
     */
    public function getDuelsB(): ArrayCollection
    {
        return $this->duelsB;
    }

    /**
     * @param ArrayCollection $duelsB
     */
    public function setDuelsB(ArrayCollection $duelsB): void
    {
        $this->duelsB = $duelsB;
    }

    /**
     * @return int
     */
    public function getDuelPlayed(): int
    {
        return $this->duelPlayed;
    }

    /**
     * @param int $duelPlayed
     */
    public function setDuelPlayed(int $duelPlayed): void
    {
        $this->duelPlayed = $duelPlayed;
    }

    /**
     * @return int
     */
    public function getDuelWin(): int
    {
        return $this->duelWin;
    }

    /**
     * @param int $duelWin
     */
    public function setDuelWin(int $duelWin): void
    {
        $this->duelWin = $duelWin;
    }

    /**
     * @return int
     */
    public function getDuelNull(): int
    {
        return $this->duelNull;
    }

    /**
     * @param int $duelNull
     */
    public function setDuelNull(int $duelNull): void
    {
        $this->duelNull = $duelNull;
    }

    /**
     * @return int
     */
    public function getDuelLoose(): int
    {
        return $this->duelLoose;
    }

    /**
     * @param int $duelLoose
     */
    public function setDuelLoose(int $duelLoose): void
    {
        $this->duelLoose = $duelLoose;
    }
}
