<?php
// load in secrets.js
$secrets = json_decode(file_get_contents('C:\xampp\htdocs\magazine\js\secrets.json', true));
// set up variables, cause I dislike this object->key->notation
$apiUrl = $secrets->steam->base_url;
$apiKey = $secrets->steam->api_key;
$apiID = $secrets->steam->my_id;
//Sanity check
echo 'url: '.$apiUrl.'   |   key: '.$apiKey.'   |   id: '.$apiID;

$ownedGamesUrl = $apiUrl.'/IPlayerService/GetOwnedGames/v1/?key='.$apiKey.'&steamid='.$apiID;
$ch = curl_init($ownedGamesUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
$output = json_decode($output, true);
//print_r($output);
$data = $output['response']['games'];
