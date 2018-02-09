<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Player extends Model
{
    /**
     * Database table name
     * @var string
     */
    protected $table = 'player';
    /**
     * A Player hasMany "A" Games
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games_a()
    {
        return $this->hasMany(Game::class, 'player_a_id');
    }

    /**
     * A Player hasMany "B" Games
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games_b()
    {
        return $this->hasMany(Game::class, 'player_a_id');
    }
}
