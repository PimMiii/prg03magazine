
window.addEventListener('load', init)


// GLOBALS
let apiUrl = "http://localhost/magazine/webservice";
let content = document.getElementById('content');

function init() {
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

function createGameCards(data) {
    for (let game of data){
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