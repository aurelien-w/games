<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerResource;
use App\Models\Player;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $players = Player::with('games_a', 'games_b')->get();

        return PlayerResource::collection($players);
    }

    /**
     * Display the specified resource.
     *
     * @param int $player
     * @return PlayerResource
     */
    public function show($player)
    {
        $player = Player::with('games_a', 'games_b')->findOrFail($player);

        return new PlayerResource($player);
    }
}
