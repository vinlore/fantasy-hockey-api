<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Httt\Response;

use App\Models\Team;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        try {
            return Team::all();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function show($id)
    {
        try {
            $team = Team::find($id);

            if (!$team) {
                return response()->error('404', 'Team not found.');
            }

            $players = $team->players()->get();
            
            foreach ($players as $player) {
                $player->setAttribute('stats', $player->statsYear()->first());
            }

            return $team->setAttribute('players', $players);
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
