<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Results
 *
 * @ORM\Table(name="results")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultsRepository")
 */
class Results implements \JsonSerializable
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
     * Results constructor.
     * @param int $userId
     * @param int $bestScore
     * @param int $lastScore
     */
    public function __construct($userId, $bestScore, $lastScore)
    {
        $this->userId = $userId;
        $this->bestScore = $bestScore;
        $this->lastScore = $lastScore;
    }


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

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return ['results' => [
            'id'            => $this->id,
            'user'          => $this->userId,
            'best_score'    => $this->bestScore,
            'last_score'    => $this->lastScore
        ]
        ];
    }
}

