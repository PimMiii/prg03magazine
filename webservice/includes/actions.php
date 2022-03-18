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
        ],
        [
            "id" => 6,
            "name" => "Euro Truck Simulator 2",
            "developer" => "SCS Software",
        ],
        [
            "id" => 7,
            "name" => "Monster Hunter: World",
            "developer" => "CAPCOM Co., Ltd.",
        ],
        [
            "id" => 8,
            "name" => "Path of Exile",
            "developer" => "Grinding Gear Games",
        ],
        [
            "id" => 9,
            "name" => "Tabletop Simulator",
            "developer" => "Berserk Games",
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
            "genres" => ['action', 'adventure']
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
        6 => [
            "playtime" => 186,
            "description" => "Travel across Europe as king of the road, a trucker who delivers important cargo across impressive distances! With dozens of cities to explore from the UK, Belgium, Germany, Italy, the Netherlands, Poland, and many more, your endurance, skill and speed will all be pushed to their limits. If you’ve got what it takes to be part of an elite trucking force, get behind the wheel and prove it!",
            "genres" => ['indie', 'simulation']
        ],
        7 => [
            "playtime" => 170,
            "description" => "Welcome to a new world! Take on the role of a hunter and slay ferocious monsters in a living, breathing ecosystem where you can use the landscape and its diverse inhabitants to get the upper hand. Hunt alone or in co-op with up to three other players, and use materials collected from fallen foes to craft new gear and take on even bigger, badder beasts!",
            "genres" => ['action']
        ],
        8 => [
            "playtime" => 155,
            "description" => "You are an Exile, struggling to survive on the dark continent of Wraeclast, as you fight to earn power that will allow you to exact your revenge against those who wronged you. Created by hardcore gamers, Path of Exile is an online Action RPG set in a dark fantasy world. With a focus on visceral action combat, powerful items and deep character customization, Path of Exile is completely free and will never be pay-to-win.",
            "genres" => ['action', 'adventure', 'free to play', 'indie', 'massively multiplayer', 'rpg']
        ],
        9 => [
            "playtime" => 154,
            "description" => "Create your own original games, import custom assets, automate games with scripting, set up complete RPG dungeons, manipulate the physics, create hinges & joints, and of course flip the table when you are losing the game. All with an easy to use system integrated with Steam Workshop. You can do anything you want in Tabletop Simulator. The possibilities are endless!",
            "genres" => ['casual', 'indie', 'rpg', 'simulation', 'strategy']
        ]
    ];

    return $tags[$id];
}
