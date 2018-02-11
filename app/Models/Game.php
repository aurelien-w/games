<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * Database table name
     * @var string
     */
    protected $table = 'duel';

    /**
     * Mass assignable fields
     * @var array
     */
    protected $fillable = [
        'player_a_id', 'player_b_id', 'score_a', 'score_b', 'rank_a', 'rank_b'
    ];

    /**
     * A Game belongsTo a Player
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player_a()
    {
        return $this->belongsTo(Player::class, 'player_a_id');
    }

    /**
     * A Game belongsTo a Player
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player_b()
    {
        return $this->belongsTo(Player::class, 'player_b_id');
    }

    /**
     * Rounds the rank_a field
     * @param $value
     */
    public function setRankAAttribute($value)
    {
        $this->attributes['rank_a'] = round($value);
    }

    /**
     * Rounds the rank_b field
     * @param $value
     */
    public function setRankBAttribute($value)
    {
        $this->attributes['rank_b'] = round($value);
    }

    /**
     * Player entity of the winner
     * @return Player|null
     */
    public function winner()
    {
        $this->loadMissing('player_a', 'player_b');

        if ($this->score_a > $this->score_b) {
            return $this->player_a;
        } elseif ($this->score_b > $this->score_a) {
            return $this->player_b;
        }

        return null;
    }

    /**
     * Player entity of the looser
     * @return Player|null
     */
    public function looser()
    {
        $this->loadMissing('player_a', 'player_b');

        if ($this->score_a < $this->score_b) {
            return $this->player_a;
        } elseif ($this->score_b < $this->score_a) {
            return $this->player_b;
        }

        return null;
    }

    /**
     * Assigns the players' new rank
     * @return Game
     */
    public function assignRanks()
    {
        $ranking = app('App\Ranking');

        if ($this->player_a->hasDraw($this)) {
            $scoreA = $ranking::DRAW;
            $scoreB = $ranking::DRAW;
        } elseif ($this->player_a->hasWon($this)) {
            $scoreA = $ranking::WIN;
            $scoreB = $ranking::LOST;
        } else {
            $scoreA = $ranking::LOST;
            $scoreB = $ranking::WIN;
        }

        $ranks = $ranking->setNewSettings(
            $this->player_a->rank,
            $this->player_b->rank,
            $scoreA,
            $scoreB
        );

        $this->player_a->update([
            'rank' => $ranks['ratingA']
        ]);

        $this->player_b->update([
            'rank' => $ranks['ratingB']
        ]);

        return $this->fill([
            'rank_a' => $ranks['diffA'],
            'rank_b' => $ranks['diffB']
        ]);
    }
}
