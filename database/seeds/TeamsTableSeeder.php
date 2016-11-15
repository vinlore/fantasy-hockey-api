<?php

use Illuminate\Database\Seeder;

use GuzzleHttp\Client as GuzzleHttpClient;

use App\Models\Team;

class TeamsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {

            $client = new GuzzleHttpClient();

            $response = $client->get(config('constants.TEAMS_API_URL'), ['verify' => false, 'query' => ['seasonId' => config('constants.REGULAR_SEASON')]]);

            $teams = json_decode($response->getBody()->getContents(), true);
            
            foreach ($teams['teams'] as $team) {
                $newTeam = [
                    'id' => $team['id'],
                    'team_abbr' => $team['abbreviation'],
                    'name' => $team['name'],
                    'divisionId' => $team['division']['id'],
                    'division' => $team['division']['name'],
                    'conferenceId' => $team['conference']['id'],
                    'conference' => $team['conference']['name']
                ];
                Team::create($newTeam);
            };

        } catch (Exception $e) {
        }
    }
}
