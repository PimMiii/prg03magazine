<?php

function getSteamGames()
{
// load in secrets.js
    $secrets = json_decode(file_get_contents('C:\xampp\htdocs\magazine\js\secrets.json', true));
// set up variables, cause I dislike this object->key->notation
    $apiUrl = $secrets->steam->base_url;
    $apiKey = $secrets->steam->api_key;
    $apiID = $secrets->steam->my_id;

    $ownedGamesUrl = $apiUrl . '/IPlayerService/GetOwnedGames/v1/?key=' . $apiKey . '&steamid=' . $apiID . '&include_appinfo=true&include_played_free_games=true';
    $ch = curl_init($ownedGamesUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output, true);
// we only need the games
    $data = $output['response']['games'];
// sort data array by playtime in descending order.
    array_multisort(array_column($data, 'playtime_forever'), SORT_DESC, $data);
    return $data;
}
