<?php

use Illuminate\Database\Seeder;

use GuzzleHttp\Client as GuzzleHttpClient;

use App\Models\Player;
use App\Models\Team;

class PlayersTableSeeder extends Seeder
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

            $params = 'cayenneExp=seasonId=' . $thisSeason;

            $s_response = $client->get(config('constants.SKATERS_BIO_API'), ['query' => $params]);
            $g_response = $client->get(config('constants.GOALIES_BIO_API'), ['query' => $params]);

            $skaters = json_decode($s_response->getBody()->getContents(), true);
            $goalies = json_decode($g_response->getBody()->getContents(), true);

            $players = array_merge($skaters['data'], $goalies['data']);
            
            foreach ($players as $data) {
                
                if (! $player = Player::find($data['playerId'])) {
                    $birthdate = new \DateTime($data['playerBirthDate']);
                    $today = new \DateTime("now");
                    $age = $today->diff($birthdate)->format('%y');

                    $player = new Player();

                    $player->id = $data['playerId'];
                    $player->first_name = $data['playerFirstName'];
                    $player->last_name = $data['playerLastName'];
                    $player->name = $data['playerName'];
                    $player->position = $data['playerPositionCode'];
                    $player->weight = $data['playerWeight'];
                    $player->height = $data['playerHeight'];
                    $player->birthplace = $data['playerBirthCountry'];
                    $player->birthdate = $data['playerBirthDate'];
                    $player->shoots = $data['playerShootsCatches'];
                    $player->draft_year = $data['playerDraftYear'];
                    $player->draft_no = $data['playerDraftOverallPickNo'];
                    $player->draft_round = $data['playerDraftRoundNo'];
                    $player->number = $data['playerCurrentSweaterNumber'];
                    $player->age = $age;

                    if ($data['playerTeamsPlayedFor']) {
                        $team = Team::where('team_abbr', $data['playerTeamsPlayedFor'])->first();
                        $player->team_abbr = $data['playerTeamsPlayedFor'];
                        $player->team()->associate($team);
                    }

                    $player->save();
                }
            }

        } catch (Exception $e) {

        }

    }
}
