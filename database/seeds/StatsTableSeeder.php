<?php

use Illuminate\Database\Seeder;

use GuzzleHttp\Client as GuzzleHttpClient;

use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;

class StatsTableSeeder extends Seeder
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

            $params = 'cayenneExp=seasonId=' . config('constants.SEASON_ID') . ' and gameTypeId=' . config('constants.REGULAR_SEASON');

            $s_response = $client->get(config('constants.SKATERS_STATS_API'), ['verify' => false, 'query' => $params]);
            $s2_response = $client->get(config('constants.SKATERS_STATS_API2'), ['verify' => false, 'query' => $params]);
            $g_response = $client->get(config('constants.GOALIES_STATS_API'), ['verify' => false, 'query' => $params]);

            $skater_stats = json_decode($s_response->getBody()->getContents(), true);
            $skater_stats2 = json_decode($s2_response->getBody()->getContents(), true);
            $goalie_stats = json_decode($g_response->getBody()->getContents(), true);

            foreach ($skater_stats['data'] as $data) {

                $player = Player::find($data['playerId']);
                $team = Team::where('team_abbr', $data['playerTeamsPlayedFor'])->first();

                if ($player) {
                    $player->team()->associate($team);
                    $player->save();
                };

                $stat = new Stat();

                $stat->player_id = $data['playerId'];
                $stat->years = $data['seasonId'];
                $stat->goals = $data['goals'];
                $stat->assists = $data['assists'];
                $stat->games_played = $data['gamesPlayed'];
                $stat->gwg = $data['gameWinningGoals'];
                $stat->plus_minus = $data['plusMinus'];
                $stat->pp_goals = $data['ppGoals'];
                $stat->pp_assists = $data['ppPoints'] - $data['ppGoals'];
                $stat->sh_goals = $data['shGoals'];
                $stat->sh_assists = $data['shPoints'] - $data['shGoals'];
                $stat->shots = $data['shots'];
                $stat->penalty_mins = $data['penaltyMinutes'];
                $stat->points_per_game = $data['pointsPerGame'];
                $stat->toi_per_game = $data['timeOnIcePerGame'];
                $stat->shifts_per_game = $data['shiftsPerGame'];
                $stat->shoot_pct = $data['shootingPctg'];
                $stat->faceoff_pct = $data['faceoffWinPctg'];

                $stat->save();
                $stat->player()->associate($player);

            }

            foreach ($skater_stats2['data'] as $data) {

                $stat = Stat::where('player_id', $data['playerId'])->where('years', $data['seasonId'])->first();

                if ($stat) {
                    $stat->blocked_shots = $data['blockedShots'];
                    $stat->faceoffs_won = $data['faceoffsWon'];
                    $stat->faceoffs_lost = $data['faceoffsLost'];
                    $stat->takeaways = $data['takeaways'];
                    $stat->hits = $data['hits'];
                    $stat->shots_per_game = $data['shotsPerGame'];

                    $stat->save();
                }

            }

            foreach ($goalie_stats['data'] as $data) {

                $player = Player::find($data['playerId']);
                $team = Team::where('team_abbr', $data['playerTeamsPlayedFor'])->first();

                if ($player) {
                    $player->team()->associate($team);
                    $player->save();
                };

                $stat = new Stat();

                $stat->player_id = $data['playerId'];
                $stat->years = $data['seasonId'];
                $stat->goals = $data['goals'];
                $stat->assists = $data['assists'];
                $stat->games_played = $data['gamesPlayed'];
                $stat->games_started = $data['gamesStarted'];
                $stat->goals_against = $data['goalsAgainst'];
                $stat->gaa = $data['goalsAgainstAverage'];
                $stat->losses = $data['losses'];
                $stat->ot_losses = $data['otLosses'];
                $stat->penalty_mins = $data['penaltyMinutes'];
                $stat->save_pct = $data['savePctg'];
                $stat->saves = $data['saves'];
                $stat->shots_against = $data['shotsAgainst'];
                $stat->shutouts = $data['shutouts'];
                $stat->wins = $data['wins'];

                $stat->save();
                $stat->player()->associate($player);

            }

        } catch (Exception $e) {

        }

    }
}
