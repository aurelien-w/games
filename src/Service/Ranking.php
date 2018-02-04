<?php

namespace App\Service;

class Ranking
{
    /**
     * @var int The K Factor used.
     */
    const KFACTOR = 50;

    const WIN = 1;
    const DRAW = 0.5;
    const LOST = 0;

    /**
     * Protected & private variables.
     */
    private $_ratingA;
    private $_ratingB;

    private $_scoreA;
    private $_scoreB;

    private $_expectedA;
    private $_expectedB;

    private $_newRatingA;
    private $_newRatingB;

    /**
     * Set new input data.
     *
     * @param int $ratingA Current rating of A
     * @param int $ratingB Current rating of B
     * @param int $scoreA Score of A
     * @param int $scoreB Score of B
     * @return array
     */
    public function setNewSettings($ratingA, $ratingB, $scoreA, $scoreB)
    {
        $this->_ratingA = $ratingA;
        $this->_ratingB = $ratingB;
        $this->_scoreA = $scoreA;
        $this->_scoreB = $scoreB;

        $expectedScores = $this->getExpectedScores($this->_ratingA, $this->_ratingB);
        $this->_expectedA = $expectedScores['a'];
        $this->_expectedB = $expectedScores['b'];

        $newRatings = $this->getNewRatings($this->_ratingA, $this->_ratingB, $this->_expectedA, $this->_expectedB, $this->_scoreA, $this->_scoreB);
        $this->_newRatingA = $newRatings['a'];
        $this->_newRatingB = $newRatings['b'];

        return array (
            'ratingA' => $this->_newRatingA,
            'diffA' => ($this->_newRatingA - $this->_ratingA),
            'ratingB' => $this->_newRatingB,
            'diffB' => ($this->_newRatingB - $this->_ratingB)
        );
    }

    /**
     * @param int $ratingA The Rating of Player A
     * @param int $ratingB The Rating of Player B
     * @return array
     */
    private function getExpectedScores($ratingA, $ratingB)
    {
        $expectedScoreA = 1 / (1 + ( pow( 10 , ($ratingB - $ratingA) / 400)));
        $expectedScoreB = 1 / (1 + ( pow( 10 , ($ratingA - $ratingB) / 400)));

        return array (
            'a' => $expectedScoreA,
            'b' => $expectedScoreB
        );
    }

    /**
     * @param int $ratingA The Rating of Player A
     * @param int $ratingB The Rating of Player A
     * @param int $expectedA The expected score of Player A
     * @param int $expectedB The expected score of Player B
     * @param int $scoreA The score of Player A
     * @param int $scoreB The score of Player B
     * @return array
     */
    private function getNewRatings($ratingA, $ratingB, $expectedA, $expectedB, $scoreA, $scoreB)
    {
        $newRatingA = $ratingA + (self::KFACTOR * ($scoreA - $expectedA));
        $newRatingB = $ratingB + (self::KFACTOR * ($scoreB - $expectedB));

        return array (
            'a' => $newRatingA,
            'b' => $newRatingB
        );
    }
}