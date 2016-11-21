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

            $today = new \DateTime('now');
            $nextYear = new \DateTime('+1 year');

            $thisSeason = $today->format('Y') . $nextYear->format('Y');

            $statsParams = 'expand=standings.record,standings.team,standings.division,standings.conference&season=' . $thisSeason;

            $response = $client->get(config('constants.TEAMS_API'), ['verify' => false]);

            $s_response = $client->get(config('constants.TEAMS_STATS_API'), ['verify' => false, 'query' => $statsParams]);

            $teams = json_decode($response->getBody()->getContents(), true);

            $teamStats = json_decode($s_response->getBody()->getContents(), true);
            
            foreach ($teams['teams'] as $team) {
                $newTeam = [
                    'id' => $team['id'],
                    'team_abbr' => $team['abbreviation'],
                    'name' => $team['name'],
                    'division' => $team['division']['name'],
                    'conference' => $team['conference']['name']
                ];
                Team::create($newTeam);
            };
            
            foreach ($teamStats['records'] as $byDivision) {
                foreach ($byDivision['teamRecords'] as $stat) {
                    $team = Team::find($stat['team']['id']);

                    if ($team) {
                        $team->goals_against = $stat['goalsAgainst'];
                        $team->goals_for = $stat['goalsScored'];
                        $team->points = $stat['points'];
                        $team->division_rank = $stat['divisionRank'];
                        $team->conference_rank = $stat['conferenceRank'];
                        $team->league_rank = $stat['leagueRank'];
                        $team->wins = $stat['leagueRecord']['wins'];
                        $team->losses = $stat['leagueRecord']['losses'];
                        $team->ot_losses = $stat['leagueRecord']['ot'];
                        $team->games_played = $stat['gamesPlayed'];
                        $team->streak = $stat['streak']['streakCode'];
                        
                        foreach ($stat['records']['overallRecords'] as $overall) {
                            switch ($overall['type']) {
                                case 'away':
                                    $team->away_record = $overall['wins'] . '-' . $overall['losses'] . '-' . $overall['ot'];
                                    break;
                                case 'home':
                                    $team->home_record = $overall['wins'] . '-' . $overall['losses'] . '-' . $overall['ot'];
                                    break;
                                case 'lastTen':
                                    $team->last_ten_record = $overall['wins'] . '-' . $overall['losses'] . '-' . $overall['ot'];
                                    break;
                            }
                        }

                        foreach ($stat['records']['conferenceRecords'] as $conference) {
                            switch ($conference['type']) {
                                case 'Eastern':
                                    $team->east_record = $conference['wins'] . '-' . $conference['losses'] . '-' . $conference['ot'];
                                    break;
                                case 'Western':
                                    $team->west_record = $conference['wins'] . '-' . $conference['losses'] . '-' . $conference['ot'];
                                    break;
                            }
                        }

                        foreach ($stat['records']['divisionRecords'] as $division) {
                            switch ($division['type']) {
                                case 'Central':
                                    $team->central_record = $division['wins'] . '-' . $division['losses'] . '-' . $division['ot'];
                                    break;
                                case 'Pacific':
                                    $team->pacific_record = $division['wins'] . '-' . $division['losses'] . '-' . $division['ot'];
                                    break;
                                case 'Atlantic':
                                    $team->atlantic_record = $division['wins'] . '-' . $division['losses'] . '-' . $division['ot'];
                                    break;
                            }
                        }

                        $team->save();
                    }
                }
            }

        } catch (Exception $e) {
        }
    }
}
