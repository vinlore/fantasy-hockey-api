<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Player;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        try {
            return Player::with('statsYear')->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function show($id)
    {
        try {
            $player = Player::find($id);

            if (!$player) {
                return response()->error('404', 'Player not found.');
            }

            return $player;
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
