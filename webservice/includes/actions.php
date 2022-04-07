<?php
require_once 'steamapi.php';
$games = [];
$lastUpdate = false;
$timeout = 60 * 60; // set timeout to 60 minutes ( 60 times 60 seconds).



function getGames()
{
    // fetch all games from my library.
    $data = getSteamGames();
    // we only need the games.
    $data = $data['response']['games'];
    // sort data array by playtime in descending order.
    array_multisort(array_column($data, 'playtime_forever'), SORT_DESC, $data);
    return $data;
}


function getGameDetails($id)
{
    // fetch game info from SteamWebAPI.
    $result = getSteamInfo($id);
    // whitelist for the keys we want te retain.
    $whitelist = ['steam_appid', 'name', 'short_description', 'website', 'developers', 'genres'];
    $result = $result[$id]['data'];
    // empty array for output.
    $output = [];
    // loop through each key in the whitelist.
    foreach ($whitelist as $key) {
        switch ($key) {
            // rename the steam_appid key to appid.
            case  'steam_appid':
                $output['appid'] = $result[$key];
                break;
            // only take the first developer if there are multiple listed.
            case 'developers':
                $output[$key] = $result[$key][0];
                break;
            // place other whitelisted keys into the output array.
            default:
                $output[$key] = $result[$key];
                break;
        }
    }
    return $output;
}
