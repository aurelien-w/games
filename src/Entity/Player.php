<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Player
{
    public function __construct()
    {
        $this->duelsA = new ArrayCollection();
        $this->duelsB = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $rank = 1000;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Duel", mappedBy="playerA")
     */
    private $duelsA;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Duel", mappedBy="playerB")
     */
    private $duelsB;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * @return mixed
     */
    public function getDuelsA()
    {
        return $this->duelsA;
    }

    /**
     * @param mixed $duelsA
     */
    public function setDuels($duelsA)
    {
        $this->duelsA = $duelsA;
    }

    /**
     * @param Duel $duel
     */
    public function addDuelA(Duel $duel)
    {
        if (!$this->duelsA->contains($duel)) {
            $this->duelsA[] = $duel;
        }
    }

    /**
     * @return mixed
     */
    public function getDuelsB()
    {
        return $this->duelsB;
    }

    /**
     * @param mixed $duelB
     */
    public function setDuelsB($duelB)
    {
        $this->duelsB = $duelB;
    }

    /**
     * @param Duel $duel
     */
    public function addDuelB(Duel $duel)
    {
        if (!$this->duelsB->contains($duel)) {
            $this->duelsB[] = $duel;
        }
    }

    /**
     * @return Duel[]
     */
    public function getDuels()
    {
        return array_merge($this->getDuelsA()->toArray(), $this->getDuelsB()->toArray());
    }

    /**
     * @return array
     */
    public function getDuelsWin()
    {
        $duels = $this->getDuels();
        $duelsWin = [];

        foreach ($duels as $duel) {
            if ($duel->getPlayerA()->getId() === $this->getId() && $duel->getScoreA() > $duel->getScoreB()) {
                $duelsWin[] = $duel;
            } elseif ($duel->getPlayerB()->getId() === $this->getId() && $duel->getScoreB() > $duel->getScoreA()) {
                $duelsWin[] = $duel;
            }
        }

        return $duelsWin;
    }

    /**
     * @return array
     */
    public function getDuelsLose()
    {
        $duels = $this->getDuels();
        $duelsLose = [];

        foreach ($duels as $duel) {
            if ($duel->getPlayerA()->getId() === $this->getId() && $duel->getScoreA() < $duel->getScoreB()) {
                $duelsLose[] = $duel;
            } elseif ($duel->getPlayerB()->getId() === $this->getId() && $duel->getScoreB() < $duel->getScoreA()) {
                $duelsLose[] = $duel;
            }
        }

        return $duelsLose;
    }

    /**
     * @return array
     */
    public function getDuelsEquality()
    {
        $duels = $this->getDuels();
        $duelsEquality = [];

        foreach ($duels as $duel) {
            if ($duel->getScoreA() === $duel->getScoreB()) {
                $duelsEquality[] = $duel;
            }
        }

        return $duelsEquality;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }
}
