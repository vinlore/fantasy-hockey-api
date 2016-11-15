<?php 

if (!defined('NHL_GOALIES')) {
	define('NHL_GOALIES', 'http://www.nhl.com/stats/rest/grouped/goalies/season/');
}


if (!defined('NHL_SKATERS')) {
    define('NHL_SKATERS', 'http://www.nhl.com/stats/rest/grouped/skaters/season/');
}


return [
    'SEASON_ID' => '20162017',
    'REGULAR_SEASON' => '2',
    'PLAYOFFS' => '3',
    'TEAMS_API_URL' => 'https://statsapi.web.nhl.com/api/v1/teams',
    'SKATERS_BIO_API' => NHL_SKATERS . 'bios',
    'SKATERS_STATS_API' => NHL_SKATERS . 'skatersummary',
    'SKATERS_STATS_API2' => NHL_SKATERS . 'realtime',
    'GOALIES_BIO_API' => NHL_GOALIES . 'bios',
    'GOALIES_STATS_API' => NHL_GOALIES . 'goaliesummary'
];
