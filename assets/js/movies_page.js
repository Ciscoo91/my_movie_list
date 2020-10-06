import { generateCard, getDetailCard } from './_card';

const form = document.getElementById("search_form");
const parentElt = document.getElementById("results");
const searchCriteriaElt = document.getElementById("search_criteria_select");
const movieCriteriaElt = document.getElementById('search_movie');


form.addEventListener('submit', (e) => {
    e.preventDefault();
    getMovies(searchCriteriaElt.value, movieCriteriaElt.value).then(() => {
        const linksElt = document.querySelectorAll(".link-info");

        console.log(linksElt)
        linksElt.forEach((link) => {
            link.addEventListener('click', () => {
                const id = link.dataset.id;
                getMovieById(id);
            })
        })
    });

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

async function getMovieById(id) {
    parentElt.innerHTML = "";
    const res = await fetch(`/details/${id}`);
    const data = await res.json();
    const card = getDetailCard(data.movie);
    console.log(data.movie);
    parentElt.innerHTML = card;
}


function proceedCardGeneration(data) {
    parentElt.innerHTML = "";
    for (const movie of data) {
        const card = generateCard(movie["title"], movie["poster_path"], movie["overview"], movie["id"], movie["release_date"]);
        parentElt.appendChild(card);
    }

}
