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
// set up variables, because I dislike this object->key->notation
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
    // construct the request-url for the steamWebAPI IPlayerService/GetOwnedGames interface.
    $ownedGamesUrl = $api['apiUrl'] . '/IPlayerService/GetOwnedGames/v1/?key=' . $api['apiKey'] . '&steamid=' . $api['apiID'] . '&include_appinfo=true&include_played_free_games=true';
    $output = apiCall($ownedGamesUrl);
    return $output;
}

function getSteamInfo($id)
{
    $apiUrl = 'https://store.steampowered.com/api/appdetails/?appids=' . $id . '&l=english';
    $output = apiCall($apiUrl);
    return $output;
}