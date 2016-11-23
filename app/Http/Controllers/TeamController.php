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

            return $team;
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
