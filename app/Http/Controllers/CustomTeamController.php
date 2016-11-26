<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\CustomTeam;
use App\Models\User;

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
                return response()->error(404, 'user_not_found');
            }

            return $user->customTeams()->get();

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->error($e->getStatusCode(), 'token_expired');

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->error($e->getStatusCode(), 'token_invalid');

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->error($e->getStatusCode(), 'token_absent');

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
                return response()->error(404, 'user_not_found');
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->error($e->getStatusCode(), 'token_expired');

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->error($e->getStatusCode(), 'token_invalid');

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->error($e->getStatusCode(), 'token_absent');

        }

        try {

            $team = new CustomTeam();
            $team->name = $request->name;
            $team->user()->associate($user->id);
            $team->save();
            
            return $team;

        } catch (Exception $e) {
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
                return response()->error('404', 'Team Not Found');
            }

            return $team->setAttribute('players', $team->players()->get());

        } catch (Exception $e) {
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
                return response()->error('404', 'Team Not Found');
            }

            $team->delete();

            return response()->success();

        } catch (Exception $e) {
            return response()->error($e);
        }
    }
}
