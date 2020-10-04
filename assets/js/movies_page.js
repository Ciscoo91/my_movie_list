// const routes = require('../../public/js/fos_js_routes.json');
// import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

// Routing.setRoutingData(routes);
// Routing.generate('rep_log_list');

import { generateCard } from './_card';

const form = document.getElementById("search_form");
const parentElt = document.getElementById("results");
const searchCriteriaElt = document.getElementById("search_criteria_select");
const movieCriteriaElt = document.getElementById('search_movie');


form.addEventListener('submit', (e) => {
    e.preventDefault();
    getMovies(searchCriteriaElt.value, movieCriteriaElt.value);
});

async function getMovies(criteria, movie) {

    const body = new FormData();
    body.append('search_criteria', criteria)
    body.append('search_movie', movie)

    const res = await fetch(`/movies/`, {
        method: "POST",
        body: body
    });
    const data = await res.json();
    console.log(data);
    if (criteria == "actor") {
        proceedCardGeneration(data);
    } else {
        proceedCardGeneration(data.results);
    }

}

function proceedCardGeneration(data) {
    parentElt.innerHTML = "";
    for (const movie of data) {
        const card = generateCard(movie["title"], movie["poster_path"], movie["overview"], movie["id"], movie["release_date"]);
        parentElt.appendChild(card);
    }

}
