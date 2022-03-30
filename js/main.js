window.addEventListener('load', init)


// GLOBALS
const apiUrl = "http://localhost/magazine/webservice";
let content = document.getElementById('content');
const secretsUrl = "./js/secrets.json"
let secrets;
let description;
let favorites = [];
let gamesList = [];
// check if favorites has been set in localstorage
if (localStorage.getItem("favorites") !== null) {
    //if favorites has been set in localstorage
    favorites = JSON.parse(localStorage.getItem("favorites"));
}
let clickedItem;
let previousTarget;


function init() {
    // create gamecards
    fetchData(apiUrl, createGameCards)
    content.addEventListener('click', contentClickHandler)
}

function fetchData(url, succcessHandler) {
    fetch(url)
        .then((response) => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json();
        })
        .then(succcessHandler)
        .catch(ajaxErrorHandler);
}


function createGameCards(data) {
    gamesList = data;
    for (let game of data) {
        // wrapper container for the game info
        let gameCard = document.createElement('div');
        gameCard.classList.add('card');
        gameCard.dataset.appid = game.appid;
        gameCard.appid = game.appid
        // game name info
        let gameName = document.createElement('h2');
        gameName.innerHTML = game.name;
        gameCard.appendChild(gameName);

        // add cover image to the card
        let cover = document.createElement('img');
        // cover.src = `http://media.steampowered.com/steamcommunity/public/images/apps/${game.appid}/${game.img_icon_url}.jpg`;
        cover.src = `https://cdn.cloudflare.steamstatic.com/steam/apps/${game.appid}/header.jpg`
        gameCard.appendChild(cover);

        // add a favourite and info button
        let favorite = document.createElement('button');
        favorite.classList.add('add-to-favorites');
        favorite.dataset.appid = game.appid;
        // set the icon to be the outline variant
        let favIcon = document.createElement('i');
        favIcon.className = 'fa-regular fa-heart'
        favorite.appendChild(favIcon)
        for (let i in favorites) {
            // if the id is in favorites, set the icon to be the filled variant
            if (favorites[i] === favorite.dataset.appid) {
                favIcon.className = 'fa-solid fa-heart';
            }
        }
        gameCard.appendChild(favorite);
        let info = document.createElement('button');
        info.classList.add('show-description');
        info.dataset.appid = game.appid;
        let infoIcon = document.createElement('i');
        infoIcon.className = 'fa-solid fa-circle-info'
        info.appendChild(infoIcon)
        gameCard.appendChild(info);
        content.appendChild(gameCard);
    }
}

function descriptionBuilder(data) {
    let information = data;
    let appid = information['appid']
    for (let game of gamesList) {
        if (game['appid'] === appid) {
            information.icon = game['img_icon_url']
            information.playtime = Math.floor(game['playtime_forever'] / 60);
        }
    }
    console.log(information)
    // if there is no description yet
    if (description === undefined) {
        // create the div and assign card class and description id
        description = document.createElement('div')
        description.classList.add('card')
        description.id = 'description'

    } else {
        // when a description is already active, select it and empty it's innerHTML
        description = document.getElementById('description')
        description.innerHTML = "";

    }
    // loop through the information object
    for (let key of Object.keys(information)) {
        let keyElement;
        keyElement = document.createElement('p');
        keyElement.classList.add(key);
        switch (key) {
            case 'playtime':
                keyElement.innerHTML = `${information[key]} uur in-game`
                break;
            case 'genres':
                let genres = [];
                for (genre of information[key]) {
                    genres.push(genre['description']);
                }
                keyElement.innerHTML = genres.join(', ');
                break;
            case 'website':
                let link = document.createElement('a');
                link.href = information[key];
                link.innerHTML = information[key];
                keyElement.appendChild(link);
                break;
            case 'appid':
                keyElement.innerHTML = `App ID: ${information[key]}`
                break;
            case 'icon':
                let icon = document.createElement('img');
                let url = `http://media.steampowered.com/steamcommunity/public/images/apps/${information['appid']}/${information[key]}.jpg`;
                icon.src = url;
                keyElement.appendChild(icon);
                break;
            default:
                keyElement.innerHTML = information[key];
        }
        description.appendChild(keyElement);

    }
    // append the description to the content grid
    content.appendChild(description);
}


function contentClickHandler(e) {
    clickedItem = e.target;
    // check to see if the clicked element is a FontAwesome icon => <i>
    if (clickedItem.tagName === 'I') {
        // if it is an icon, we need the parentNode to decide our action
        let parentItem = clickedItem.parentNode;
        switch (parentItem.className) {
            case 'add-to-favorites':
                // favorite icon has been clicked
                favoriteClickHandler(clickedItem, parentItem)
                break;
            case 'show-description':
                // info icon has been clicked
                infoClickHandler(clickedItem, parentItem)
                break;
        }
    }
}

function favoriteClickHandler(clickedItem, parentItem, e) {

    let found = false;
    for (let i in favorites) {

        if (favorites[i] === parentItem.dataset.appid) {
            found = true;
            favorites.splice(i, 1);
            clickedItem.className = 'fa-regular fa-heart'
        }
    }
    if (!found) {
        favorites.push(parentItem.dataset.appid);
        clickedItem.className = 'fa-solid fa-heart'
    }
    localStorage.setItem('favorites', JSON.stringify(favorites))
}

function infoClickHandler(clickedItem, parentItem, e) {
    if (previousTarget !== undefined) {
        previousTarget.id = '';
    }
    clickedItem.id = 'description-active';
    previousTarget = clickedItem
    console.log(`${apiUrl}?id=${parentItem.dataset.appid}`)
    fetchData(`${apiUrl}?id=${parentItem.dataset.appid}`, descriptionBuilder)


}

function ajaxErrorHandler(data) {
    console.log(data)
    let error = document.createElement('div');
    error.classList.add('error');
    error.innerHTML = "Er ging iets fout. Probeer later nog eens!";
    content.before(error);
}