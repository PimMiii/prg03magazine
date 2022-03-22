window.addEventListener('load', init)


// GLOBALS
const apiUrl = "http://localhost/magazine/webservice";
let content = document.getElementById('content');
const secretsUrl = "./js/secrets.json"
let secrets;



function init() {
    //load secrets in.
    fetchData(secretsUrl, setSecrets)
    // retrieve acces token for IGDB API

    // create all gamecards
    fetchData(apiUrl, createGameCards)
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
function createGameCards(data) {
    for (let game of data) {
        // wrapper container for the game info
        let gameCard = document.createElement('div');
        gameCard.classList.add('card');
        gameCard.dataset.id = game.id;
        // game name info
        let gameName = document.createElement('h2');
        gameName.innerHTML = game.name;
        gameCard.appendChild(gameName);

        // add a favourite and info button
        let favorite = document.createElement('button');
        favorite.classList.add('add-to-favorites');
        favorite.innerHTML = '<i class="fa-regular fa-heart"></i>'
        gameCard.appendChild(favorite);
        let info = document.createElement('button');
        info.classList.add('show-description')
        info.innerHTML = '<i class="fa-solid fa-circle-info"></i>'
        gameCard.appendChild(info);

        content.appendChild(gameCard);
    }
}

function ajaxErrorHandler(data) {
    console.log(data)
    let error = document.createElement('div');
    error.classList.add('error');
    error.innerHTML = "Er ging iets fout. Probeer later nog eens!";
    content.before(error);
}