<?php 

if (!defined('NHL_PLAYERS')) {
    define('NHL_PLAYERS', 'http://www.nhl.com/stats/rest/');
}

return [
    'SEASON_ID' => '20162017',
    'REGULAR_SEASON' => '2',
    'PLAYOFFS' => '3',
    'TEAMS_API_URL' => 'https://statsapi.web.nhl.com/api/v1/teams',
    'SKATERS_BIO_API' => NHL_PLAYERS . 'grouped/skaters/season/bios',
    'SKATERS_STATS_API' => NHL_PLAYERS . 'individual/skaters/basic/season/skatersummary',
    'SKATERS_STATS_API2' => NHL_PLAYERS . 'individual/skaters/basic/season/realtime',
    'GOALIES_BIO_API' => NHL_PLAYERS . 'grouped/goalies/season/bios',
    'GOALIES_STATS_API' => NHL_PLAYERS . 'individual/goalies/basic/season/goaliesummary',
    'SKATERS_GAME_STATS_API' => NHL_PLAYERS . 'individual/skaters/basic/game/skatersummary',
    'SKATERS_GAME_STATS_API2' => NHL_PLAYERS . 'individual/skaters/basic/game/realtime',
    'GOALIES_GAME_STATS_API' => NHL_PLAYERS . 'individual/goalies/basic/game/goaliesummary'
];
