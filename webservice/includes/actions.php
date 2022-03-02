<?php
/**
 * @return array
 */
function getGames()
{
    return [
        [
            "id" => 1,
            "name" => "Rocket League",
            "developer" => "Psyonix LLC",
        ],
        [
            "id" => 2,
            "name" => "Grand Theft Auto V",
            "developer" => "Rockstar North",
        ],
        [
            "id" => 3,
            "name" => "Factorio",
            "developer" => "Wube Software LTD.",
        ],
        [
            "id" => 4,
            "name" => "Destiny 2",
            "developer" => "Bungie",
        ],
        [
            "id" => 5,
            "name" => "Cities: Skylines",
            "developer" => "Colossal Order Ltd.",
        ]
    ];
}

/**
 * @param $id
 * @return mixed
 */
function getGameDetails($id)
{
    $tags = [
        1 => [
            "playtime" => 1898,
            "description" => "Rocket League is a high-powered hybrid of arcade-style soccer and vehicular mayhem with easy-to-understand controls and fluid, physics-driven competition. Rocket League includes casual and competitive Online Matches, a fully-featured offline Season Mode, special “Mutators” that let you change the rules entirely, hockey and basketball-inspired Extra Modes, and more than 500 trillion possible cosmetic customization combinations.

Winner or nominee of more than 150 “Game of the Year” awards, Rocket League is one of the most critically-acclaimed sports games of all time. Boasting a community of more than 57 million players, Rocket League features ongoing free and paid updates, including new DLCs, content packs, features, modes and arenas.",
            "genres" => ['action', 'indie', 'racing', 'sports']
        ],
        2 => [
            "playtime" => 395,
            "description" => "When a young street hustler, a retired bank robber and a terrifying psychopath find themselves entangled with some of the most frightening and deranged elements of the criminal underworld, the U.S. government and the entertainment industry, they must pull off a series of dangerous heists to survive in a ruthless city in which they can trust nobody, least of all each other.
",
            "genres" => ['adventure', 'adventure']
        ],
        3 => [
            "playtime" => 287,
            "description" => "Factorio is a game in which you build and maintain factories. You will be mining resources, researching technologies, building infrastructure, automating production and fighting enemies. In the beginning you will find yourself chopping trees, mining ores and crafting mechanical arms and transport belts by hand, but in short time you can become an industrial powerhouse, with huge solar fields, oil refining and cracking, manufacture and deployment of construction and logistic robots, all for your resource needs. However this heavy exploitation of the planet's resources does not sit nicely with the locals, so you will have to be prepared to defend yourself and your machine empire.",
            "genres" => ['casual', 'indie', 'simulation', 'strategy']
        ],
        4 => [
            "playtime" => 207,
            "description" => "Dive into the world of Destiny 2 to explore the mysteries of the solar system and experience responsive first-person shooter combat. Unlock powerful elemental abilities and collect unique gear to customize your Guardian's look and playstyle. Enjoy Destiny 2’s cinematic story, challenging co-op missions, and a variety of PvP modes alone or with friends. Download for free today and write your legend in the stars.",
            "genres" => ['action', 'adventure', 'free to play']
        ],
        5 => [
            "playtime" => 199,
            "description" => "Cities: Skylines is a modern take on the classic city simulation. The game introduces new game play elements to realize the thrill and hardships of creating and maintaining a real city whilst expanding on some well-established tropes of the city building experience. You’re only limited by your imagination, so take control and reach for the sky!",
            "genres" => ['simulation', 'strategy']
        ],
    ];

    return $tags[$id];
}
