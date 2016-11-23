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
            $players = Player::all();

            if (!$players) {
                return response()->error('404', 'Players not found.');
            }

            if (!$request->years) {
                $today = new \DateTime('now');
                $nextYear = new \DateTime('+1 year');

                $years = $today->format('Y') . $nextYear->format('Y');
            } else {
                $years = $request->years;
            }

            foreach ($players as $player) {
                $player->setAttribute('stats', $player->statsYear()->where('years', $years)->first());
            }

            return $players;

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
