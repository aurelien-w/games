<?php

namespace App\Entity;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeasonRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Season
{
    const STATUS_WAITING     = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETED   = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    private $finishAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerSeasonData", mappedBy="season")
     * @ORM\OrderBy({"rank" = "DESC"})
     */
    private $playerSeasonData;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SeasonDuel", mappedBy="season")
     */
    private $duels;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->playerSeasonData = new ArrayCollection();
        $this->duels = new ArrayCollection();
    }

    public function isCurrentMonthSeason(): bool
    {
        return (new \DateTime())->format('m') === $this->startAt->format('m');
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
    public function getStatus(): int
    {
        $today = new Carbon();

        if ($today->greaterThan($this->getFinishAt())) {
            return self::STATUS_COMPLETED;
        }

        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getStartAt(): \DateTime
    {
        return $this->startAt;
    }

    /**
     * @param \DateTime $startAt
     */
    public function setStartAt(\DateTime $startAt): void
    {
        $this->startAt = $startAt;
    }

    /**
     * @return \DateTime
     */
    public function getFinishAt(): \DateTime
    {
        return $this->finishAt;
    }

    /**
     * @param \DateTime $finishAt
     */
    public function setFinishAt(\DateTime $finishAt): void
    {
        $this->finishAt = $finishAt;
    }

    /**
     * @return ArrayCollection
     */
    public function getPlayerSeasonData()
    {
        return $this->playerSeasonData;
    }

    /**
     * @param ArrayCollection $playerSeasonData
     */
    public function setPlayerSeasonData(ArrayCollection $playerSeasonData): void
    {
        $this->playerSeasonData = $playerSeasonData;
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function hasPlayer(Player $player): bool
    {
        foreach ($this->getPlayerSeasonData() as $seasonDatum) {
            if ($seasonDatum->getPlayer()->getId() === $player->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return int
     */
    public function getNbPlayers(): int
    {
        return $this->playerSeasonData->count();
    }

    /**
     * @return int
     */
    public function getNbMissingPlayerToStart()
    {
        $diff = 2 - $this->playerSeasonData->count();

        if ($diff < 0) {
            $diff = 0;
        }

        return $diff;
    }

    /**
     * @return ArrayCollection
     */
    public function getDuels()
    {
        return $this->duels;
    }

    /**
     * @param ArrayCollection $duels
     */
    public function setDuels(ArrayCollection $duels): void
    {
        $this->duels = $duels;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->status = self::STATUS_WAITING;
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
