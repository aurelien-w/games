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
        'player_a_id', 'player_b_id', 'score_a', 'score_b'
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
}
