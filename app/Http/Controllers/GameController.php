<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Game validation rules
     * @param Request $request
     * @return mixed - Validated data array
     */
    protected function validates(Request $request) {
        return $request->validate([
            'player_a' => 'required|different:player_b|exists:players,id',
            'player_b' => 'required|different:player_a|exists:players,id',
            'score_a'  => 'required|numeric|min:0',
            'score_b'  => 'required|numeric|min:0'
        ]);
    }
}
