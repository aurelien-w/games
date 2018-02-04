<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DuelRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Duel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="duels", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\NotBlank()
     */
    private $playerA;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="duels", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\NotBlank()
     */
    private $playerB;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    private $scoreA;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    private $scoreB;

    /**
     * @ORM\Column(type="integer")
     */
    private $rankA;

    /**
     * @ORM\Column(type="integer")
     */
    private $rankB;

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
    public function getPlayerA()
    {
        return $this->playerA;
    }

    /**
     * @param mixed $playerA
     */
    public function setPlayerA($playerA)
    {
        $this->playerA = $playerA;
    }

    /**
     * @return mixed
     */
    public function getPlayerB()
    {
        return $this->playerB;
    }

    /**
     * @param mixed $playerB
     */
    public function setPlayerB($playerB)
    {
        $this->playerB = $playerB;
    }

    /**
     * @return mixed
     */
    public function getScoreA()
    {
        return $this->scoreA;
    }

    /**
     * @param mixed $scoreA
     */
    public function setScoreA($scoreA)
    {
        $this->scoreA = $scoreA;
    }

    /**
     * @return mixed
     */
    public function getScoreB()
    {
        return $this->scoreB;
    }

    /**
     * @param mixed $scoreB
     */
    public function setScoreB($scoreB)
    {
        $this->scoreB = $scoreB;
    }

    /**
     * @return mixed
     */
    public function getRankA()
    {
        return $this->rankA;
    }

    /**
     * @param mixed $rankA
     */
    public function setRankA($rankA)
    {
        $this->rankA = $rankA;
    }

    /**
     * @return mixed
     */
    public function getRankB()
    {
        return $this->rankB;
    }

    /**
     * @param mixed $rankB
     */
    public function setRankB($rankB)
    {
        $this->rankB = $rankB;
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
