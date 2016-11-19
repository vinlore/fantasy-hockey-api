<?php

use Illuminate\Database\Seeder;

use GuzzleHttp\Client as GuzzleHttpClient;

use App\Models\Player;
use App\Models\StatYear;
use App\Models\StatMonth;
use App\Models\StatBiweek;
use App\Models\StatWeek;

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

            $today = new \DateTime('now');
            $nextYear = new \DateTime('+1 year');
            $lastWeek = new \DateTime('-7 days');
            $last2Week = new \DateTime('-14 days');
            $lastMonth = new \DateTime('-30 days');

            $thisSeason = $today->format('Y') . $nextYear->format('Y');

            $params = 'cayenneExp=gameTypeId=' . config('constants.REGULAR_SEASON') . ' and seasonId=' . $thisSeason;

            $paramsWeek = ' and gameDate>="' . $lastWeek->format('Y-m-d') . '" and gameDate<="' . $today->format('Y-m-d') . '"';

            $paramsBiweek = ' and gameDate>="' . $last2Week->format('Y-m-d') . '" and gameDate<="' . $today->format('Y-m-d') . '"';

            $paramsMonth = ' and gameDate>="' . $lastMonth->format('Y-m-d') . '" and gameDate<="' . $today->format('Y-m-d') . '"';

            $this->create_stat($client, $params, 'year', $thisSeason, false);
            $this->create_stat($client, $params . $paramsWeek, 'week', $thisSeason, true);
            $this->create_stat($client, $params . $paramsBiweek, 'biweek', $thisSeason, true);
            $this->create_stat($client, $params . $paramsMonth, 'month', $thisSeason, true);

        } catch (Exception $e) {

        }

    }

    public function create_stat($client, $params, $span, $season, $isSeason)
    {
        if ($isSeason) {
            $skatersUrl = config('constants.SKATERS_GAME_STATS_API');
            $skatersUrl2 = config('constants.SKATERS_GAME_STATS_API2');
            $goaliesUrl = config('constants.GOALIES_GAME_STATS_API');
        } else {
            $skatersUrl = config('constants.SKATERS_STATS_API');
            $skatersUrl2 = config('constants.SKATERS_STATS_API2');
            $goaliesUrl = config('constants.GOALIES_STATS_API');
        }

        $s_response = $client->get($skatersUrl, ['verify' => false, 'query' => $params]);
        $s2_response = $client->get($skatersUrl2, ['verify' => false, 'query' => $params]);
        $g_response = $client->get($goaliesUrl, ['verify' => false, 'query' => $params]);

        $skater_stats = json_decode($s_response->getBody()->getContents(), true);
        $skater_stats2 = json_decode($s2_response->getBody()->getContents(), true);
        $goalie_stats = json_decode($g_response->getBody()->getContents(), true);

        foreach ($skater_stats['data'] as $data) {

            $player = Player::find($data['playerId']);

            switch ($span) {
                case 'year':
                    $stat = new StatYear();
                    $stat->years = $season;
                    $stat->points_per_game = $data['pointsPerGame'];
                    break;
                case 'month':
                    $stat = new StatMonth();
                    break;
                case 'biweek':
                    $stat = new StatBiweek();
                    break;
                case 'week':
                    $stat = new StatWeek();
                    break;
            }

            $stat->player_id = $data['playerId'];
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
            $stat->toi_per_game = $data['timeOnIcePerGame'];
            $stat->shifts_per_game = $data['shiftsPerGame'];
            $stat->shoot_pct = $data['shootingPctg'];
            $stat->faceoff_pct = $data['faceoffWinPctg'];

            $stat->save();
            $stat->player()->associate($player);

        }

        foreach ($skater_stats2['data'] as $data) {

            switch ($span) {
                case 'year':
                    $stat = StatYear::where('player_id', $data['playerId'])->where('years', $season)->first();
                    break;
                case 'month':
                    $stat = StatMonth::where('player_id', $data['playerId'])->first();
                    break;
                case 'biweek':
                    $stat = StatBiweek::where('player_id', $data['playerId'])->first();
                    break;
                case 'week':
                    $stat = StatWeek::where('player_id', $data['playerId'])->first();
                    break;
            }

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

            switch ($span) {
                case 'year':
                    $stat = new StatYear();
                    $stat->years = $season;
                    break;
                case 'month':
                    $stat = new StatMonth();
                    break;
                case 'biweek':
                    $stat = new StatBiweek();
                    break;
                case 'week':
                    $stat = new StatWeek();
                    break;
            }

            $stat->player_id = $data['playerId'];
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
    }
}
