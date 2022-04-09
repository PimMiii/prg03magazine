<?php
require_once 'steamapi.php';



function getGames()
{

    // fetch all games from my library.
    $data = getSteamGames();
    // we only need the games.
    $data = $data['response']['games'];
    // sort data array by playtime in descending order.
    array_multisort(array_column($data, 'playtime_forever'), SORT_DESC, $data);
    // create a profile object, to have my 'own' data in the API
    $socials = [
        "insta" => ["icon"=>"fa-brands fa-instagram", "url"=>"https://www.instagram.com/pimmothy_cmgt/"],
        "twitter" => ["icon"=>"fa-brands fa-twitter", "url"=>"https://twitter.com/PimMiii"],
        "github" => ["icon"=>"fa-brands fa-github", "url"=>"https://github.com/PimMiii"]
    ];
    $profile = [
        "appid" => "profile",
        "name" => "Profiel",
        "student_id" => "1030831",
        "Student_name" => "Pim van Milt",
        "course" => "PRG03",
        "description" => "Ik heb Games gekozen voor mijn magazine, vooral omdat ik zelf graag game. Maar ook na mijn diploma graag de Gamesindustrie in zou gaan, om games te maken die mensen zich herinneren. Omdat de game ze geraakt heeft, of om een andere reden speciaal voor ze is.",
        "steam_name" => "PimMiii",
        "steam_img" => "https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/29/296ccd9de05ce5aac2befce59b0c3cf3c2d72136_full.jpg",
        "socials" => $socials
    ];
    $profile = (object)$profile;
    // add it to the data
    $data[] = $profile;

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
