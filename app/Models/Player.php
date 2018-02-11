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

    /**
     * A Player hasMany Games
     * @return Collection
     */
    public function games()
    {
        return (
            new Collection($this->games_a)
        )->concat($this->games_b);
    }

    /**
     * Collection of victorious games
     * @return mixed
     */
    public function victories()
    {
        return $this->games()->filter(function(Game $game) {
            return $this->hasWon($game);
        });
    }

    /**
     * Collection of lost games
     * @return mixed
     */
    public function losses()
    {
        return $this->games()->filter(function(Game $game) {
            return $this->hasLost($game);
        });
    }

    /**
     * Collection of draw games
     * @return mixed
     */
    public function draws()
    {
        return $this->games()->filter(function(Game $game) {
            return $this->hasDraw($game);
        });
    }

    /**
     * Determines if the player has won the game
     * @param Game $game
     * @return bool
     */
    public function hasWon(Game $game)
    {
        return optional($game->winner())->id === $this->id;
    }

    /**
     * Determines if the player has lost the game
     * @param Game $game
     * @return bool
     */
    public function hasLost(Game $game)
    {
        return optional($game->looser())->id === $this->id;
    }

    /**
     * Determines if the game is a draw
     * @param Game $game
     * @return bool
     */
    public function hasDraw(Game $game)
    {
        return is_null(
            $game->winner()
        );
    }
}
