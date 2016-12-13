<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\CustomTeam;
use App\Models\User;
use App\Models\Player;

class CustomTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            
            $user = \JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response('user_not_found', 404);
            }

            return $user->customTeams()->get();

        } catch (\Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            
            $user = \JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response('user_not_found', 404);
            }

            $team = new CustomTeam();
            $team->name = $request->name;
            $team->user()->associate($user->id);
            $team->save();
            
            return $team;

        } catch (\Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            
            $team = CustomTeam::find($id);

            if (!$team) {
                return response('team_not_found', 404);
            }

            return $team->setAttribute('players', $team->players()->get());

        } catch (\Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $team = CustomTeam::find($id);
            if (!$team) {
                return response('team_not_found', 404);
            }

            $team->delete();

            return response()->success();

        } catch (\Exception $e) {
            return response()->error($e);
        }
    }

    public function addPlayer($teamId, $playerId)
    {
        try {

            $team = CustomTeam::find($teamId);
            if (!$team) {
                return response('team_not_found', 404);
            }

            $player = Player::find($playerId);
            if (!$player) {
                return response('player_not_found', 404);
            }

            $team->players()->attach($player->id);

            return response()->success();

        } catch (\Exception $e) {
            if ($e->errorInfo[0] == 23000) {
                return response('duplicate_player', 500);
            }
            return response()->error($e->errorInfo);
        }
    }
}
