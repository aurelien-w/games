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
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player_b()
    {
        return $this->belongsTo(Player::class, 'player_b_id');
    }
}
