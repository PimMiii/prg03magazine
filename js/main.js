window.addEventListener('load', init)


// GLOBALS
const apiUrl = "http://localhost/magazine/webservice";
let content = document.getElementById('content');
const secretsUrl = "./js/secrets.json"
let secrets;
let description;
let favorites = [];
// check if favorites has been set in localstorage
if (localStorage.getItem("favorites") !== null) {
    //if favorites has been set in localstorage
    favorites = JSON.parse(localStorage.getItem("favorites"));
}
let previousTarget;



function init() {
    //load secrets in.
    //fetchData(secretsUrl, setSecrets)
    // retrieve acces token for IGDB API

    // create all gamecards
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

function postData(url = '', successHandler, mode,  headers = {}, data = {}) {
    // Default options are marked with *
    fetch(url, {
        method: 'POST',
        mode: mode, // no-cors, *cors, same-origin
        // cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        // credentials: 'same-origin', // include, *same-origin, omit
        headers: headers,
        // redirect: 'follow', // manual, *follow, error
        // referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body:JSON.stringify(data) // body data type must match "Content-Type" header
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json();
        })
        .then(successHandler)
        .catch(ajaxErrorHandler);
}

function createGameCards(data) {
    for (let game of data) {
        // wrapper container for the game info
        let gameCard = document.createElement('div');
        gameCard.classList.add('card');
        gameCard.dataset.id = game.id;
        gameCard.id = game.id
        // game name info
        let gameName = document.createElement('h2');
        gameName.innerHTML = game.name;
        gameCard.appendChild(gameName);

        // add cover image to the card
        let cover = document.createElement('img');
        cover.src = game.img;
        gameCard.appendChild(cover);

        // add a favourite and info button
        let favorite = document.createElement('button');
        favorite.classList.add('add-to-favorites');
        favorite.dataset.id = game.id;
        // set the icon to be the outline variant
        let favIcon = document.createElement('i');
        favIcon.className = 'fa-regular fa-heart'
        favorite.appendChild(favIcon)
        for (let i in favorites){
            // if the id is in favorites, set the icon to be the filled variant
            if (favorites[i] === favorite.dataset.id) {
                favIcon.className = 'fa-solid fa-heart';
            }
        }
        gameCard.appendChild(favorite);
        let info = document.createElement('button');
        info.classList.add('show-description');
        info.dataset.id = game.id;
        let infoIcon = document.createElement('i');
        infoIcon.className = 'fa-solid fa-circle-info'
        info.appendChild(infoIcon)
        gameCard.appendChild(info);
        content.appendChild(gameCard);
    }
}

function descriptionBuilder(data) {
    let information = data
    // if there is no description yet
    if(description === undefined) {
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
    for(let key of Object.keys(information)) {
        let keyElement;
        if (key === 'name') {
            // name should be a h2 element
            keyElement = document.createElement('h2');
        } else {
            keyElement = document.createElement('p');
        }
        //give the element it's class, information and append it to the description div
        keyElement.classList.add(key);
        keyElement.innerHTML = information[key];
        description.appendChild(keyElement);

    }
    // append the description to the content grid
    content.appendChild(description);
}


function contentClickHandler(e) {
    let clickedItem = e.target;
    // check to see if the clicked element is a FontAwesome icon => <i>
    if (clickedItem.tagName === 'I') {
        // if it is an icon, we need the parentNode to decide our action
        let parentItem = clickedItem.parentNode;
        switch(parentItem.className) {
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

function favoriteClickHandler(clickedItem, parentItem, e){

    let found = false;
    for (let i in favorites) {

        if (favorites[i] === parentItem.dataset.id) {
            found = true;
            favorites.splice(i, 1);
            clickedItem.className = 'fa-regular fa-heart'
        }
    }
    if (!found) {
        favorites.push(parentItem.dataset.id);
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
    console.log(`${apiUrl}?id=${parentItem.dataset.id}`)
    fetchData(`${apiUrl}?id=${parentItem.dataset.id}`, descriptionBuilder)


}


//IGDB related functions
function igdbGameFetch(data) {
    console.log(data);
}


function setSecrets(data) {
    secrets = data
    let igdb = secrets.igdb
    igdb.token_url = `${igdb.oauth_url}?client_id=${igdb.client_id}&client_secret=${igdb.client_secret}&grant_type=client_credentials`;
    console.log(secrets)
    postData(secrets.igdb.token_url, getAccessToken, 'cors')
}

function getAccessToken(data) {
    let results = data;
    secrets.igdb.access_token = results.access_token;
    secrets.igdb.token_type = results.token_type;

    // Test fetch games from IGDB
    let gameUrl = `${secrets.igdb.base_url}/games`
    let headers =
        [`Client-ID: ${secrets.igdb.client_id}`,
            `Authorization: Bearer ${secrets.igdb.access_token}`
        ]
    console.log(headers)
    let body = 'fields *';
    postData(gameUrl, igdbGameFetch, 'no-cors', headers, body)
}

function ajaxErrorHandler(data) {
    console.log(data)
    let error = document.createElement('div');
    error.classList.add('error');
    error.innerHTML = "Er ging iets fout. Probeer later nog eens!";
    content.before(error);
}