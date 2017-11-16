<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Results
 *
 * @ORM\Table(name="results")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultsRepository")
 */
class Results
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="best_score", type="integer")
     */
    private $bestScore;

    /**
     * @var int
     *
     * @ORM\Column(name="last_score", type="integer")
     */
    private $lastScore;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Results
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set bestScore
     *
     * @param integer $bestScore
     *
     * @return Results
     */
    public function setBestScore($bestScore)
    {
        $this->bestScore = $bestScore;

        return $this;
    }

    /**
     * Get bestScore
     *
     * @return int
     */
    public function getBestScore()
    {
        return $this->bestScore;
    }

    /**
     * Set lastScore
     *
     * @param integer $lastScore
     *
     * @return Results
     */
    public function setLastScore($lastScore)
    {
        $this->lastScore = $lastScore;

        return $this;
    }

    /**
     * Get lastScore
     *
     * @return int
     */
    public function getLastScore()
    {
        return $this->lastScore;
    }
}

