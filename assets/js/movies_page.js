const form = document.getElementById("search_form");
const parentElt = document.getElementById("results");
const searchCriteriaElt = document.getElementById("search_criteria_select");
const movieCriteriaElt = document.getElementById('search_movie');


form.addEventListener('submit', (e) => {
    e.preventDefault();
    getTitanic(searchCriteriaElt.value, movieCriteriaElt.value);
})


async function getTitanic(criteria, movie) {

    const body = new FormData();
    body.append('search_criteria', criteria)
    body.append('search_movie', movie)

    const res = await fetch(`/movies/`, {
        method: "POST",
        body: body
    });
    const data = await res.json();
    // console.log(data);
    if (criteria == "actor") {
        proceedCardGeneration(data);
    } else {
        proceedCardGeneration(data.results);
    }
}


function* generateMovieCard(data) {

    for (movie of data) {
        console.log("movie to generate", movie);
        yield `
        <div class="col-3">
            <div class="card mb-3">
                <img src="https://image.tmdb.org/t/p/w1280/${movie["poster_path"]}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">${movie['title']}</h5>
                    <p class="card-text">${movie['overview'].slice(0, 100)} <a class="link-info" href="${movie["id"]}">See more...</a></p>
                    <p class="card-text"><small class="text-muted">Release date: ${movie['release_date']}</small></p>
                </div>
            </div>
        </div>    
    `
    }
}

function proceedCardGeneration(data) {
    const generatedData = generateMovieCard(data);
    parentElt.innerHTML = "";
    while (generatedData.next().done === false) {
        console.log(generatedData.next().done);
        console.log("movie generated", generatedData.next.value);
        parentElt.innerHTML += `${generatedData.next().value}`;
    }
}
