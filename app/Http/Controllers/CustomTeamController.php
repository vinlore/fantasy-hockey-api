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

            return $user->customTeams()->with('players')->get();

        } catch (\Exception $e) {
            return response($e->errorInfo, 500);
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
            return response($e->errorInfo, 500);
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
            
            $user = \JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response('user_not_found', 404);
            }

            $team = $user->customTeams()->where('id', $id)->first();
            if (!$team) {
                return response('team_not_found', 404);
            }

            return $team->setAttribute('players', $team->players()->get());

        } catch (\Exception $e) {
            return response($e->errorInfo, 500);
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
            return response($e->errorInfo, 500);
        }
    }

    public function add_player($teamId, $playerId)
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
            return response($e->errorInfo, 500);
        }
    }

    public function index_available($pid)
    {
        try {

            $user = \JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response('user_not_found', 404);
            }

            $teams = $user->customTeams()->get();
            $ignore_teams = [];
            foreach($teams as $team) {
                $t = $team->players()->wherePivot('player_id', '=', $pid)->first();
                if ($t) {
                    array_push($ignore_teams, $t->pivot->custom_team_id);
                }
            }
            
            return $user->customTeams()->whereNotIn('id', $ignore_teams)->get();

        } catch (\Exception $e) {
            return response($e, 500);
        }
    }
}
