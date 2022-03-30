<?php

function apiCall($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}

function loadSecrets()
{
    // load in secrets.js
    $secrets = json_decode(file_get_contents('C:\xampp\htdocs\magazine\js\secrets.json', true));
// set up variables, cause I dislike this object->key->notation
    $output = array(
        'apiUrl' => $secrets->steam->base_url,
        'apiKey' => $secrets->steam->api_key,
        'apiID' => $secrets->steam->my_id,
    );
    return $output;
}

function getSteamGames()
{
// load in secrets.js
    $api = loadSecrets();

    $ownedGamesUrl = $api['apiUrl'] . '/IPlayerService/GetOwnedGames/v1/?key=' . $api['apiKey'] . '&steamid=' . $api['apiID'] . '&include_appinfo=true&include_played_free_games=true';
    $output = apiCall($ownedGamesUrl);
// we only need the games
    $data = $output['response']['games'];
// sort data array by playtime in descending order.
    array_multisort(array_column($data, 'playtime_forever'), SORT_DESC, $data);
    return $data;
}

function getSteamInfo($id)
{
    $apiUrl = 'https://store.steampowered.com/api/appdetails/?appids=' . $id . '&l=english';
    $output = apiCall($apiUrl);
    $output = $output[$id]['data'];
    $whitelist = ['steam_appid', 'name', 'short_description', 'website', 'developers', 'genres'];
    $newOutput = [];
    foreach ($whitelist as $key) {
        if ($key === 'steam_appid') {
            $newOutput['appid'] = $output[$key];
        } else {
            $newOutput[$key] = $output[$key];
        }
    }
    return $newOutput;
}