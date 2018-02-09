<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Player::with('games_a', 'games_b')->get();
    }

    /**
     * Display the specified resource.
     *
     * @param int $player
     * @return Player|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show($player)
    {
        return Player::with('games_a', 'games_b')->findOrFail($player);
    }
}
