export const generateCard = (title, poster_path, overview, id, release_date) => {

    const mainDiv = document.createElement("div");
    mainDiv.classList.add("col-3", "col-md-4", "col-sm-10");
    const cardDiv = document.createElement("div");
    cardDiv.classList.add("card", "mb-3");
    const imageElt = document.createElement("img");
    imageElt.src = `https://image.tmdb.org/t/p/w1280/${poster_path}`
    imageElt.alt = title;
    imageElt.classList.add("card-img-top");
    const cardBody = document.createElement("div");
    cardBody.classList.add("card-body");
    const cardBodyHeading = document.createElement("h5");
    cardBodyHeading.textContent = title;
    cardBodyHeading.classList.add("card-title");
    const firstCardParagraph = document.createElement("p");
    firstCardParagraph.classList.add("card-text");
    firstCardParagraph.textContent = `${overview.slice(0, 100)}`
    const link = document.createElement("a");
    link.textContent = "See more...";
    link.classList.add("link-info");
    link.setAttribute("data-id", id);
    link.style.cursor = "pointer";
    const secondCardParagraph = document.createElement("p");
    secondCardParagraph.classList.add("card-text");
    const smallElt = document.createElement("small");
    smallElt.classList.add("text-muted");
    smallElt.textContent = `Release date: ${release_date}`;


    secondCardParagraph.appendChild(smallElt);
    firstCardParagraph.appendChild(document.createElement("br"));
    firstCardParagraph.appendChild(link);
    cardBody.appendChild(cardBodyHeading)
    cardBody.appendChild(firstCardParagraph)
    cardBody.appendChild(secondCardParagraph);
    cardDiv.appendChild(imageElt);
    cardDiv.appendChild(cardBody);
    mainDiv.appendChild(cardDiv);

    return mainDiv;

}


export function getDetailCard(movie) {
    return `
        <div class="row">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-2 py-2">
                    <img class="img-thumbnail" src="https://image.tmdb.org/t/p/w1280/${movie.poster_path}" alt="${movie.title}_movie_poster">
                </div>
                <div class="col-md-8 ml-4">
                    <div class="row">
                        <div class="card-body">
                            <table class="table table-borderless py-3 ml-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Title</th>
                                        <td colspan="2">${movie.title}</td>
                                        <td><a class="display-6 " data-toggle="tooltip" data-placement="top"
                                                title="Add to favorites" href="">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                    class="bi bi-star-fill text-warning" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                            </a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Produced by</th>
                                        <td>${movie.producer}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Popularity</th>
                                        <td colspan="2">${movie.popularity}/100</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tagline</th>
                                        <td colspan="2">${movie.tagline}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Release Date</th>
                                        <td colspan="2">${movie.release_date}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card px-0">
                    <div class="card-header">
                        Overview
                    </div>
                    <div class="card-body">
                        ${movie.overview}
                    </div>
                    <div class="card-footer text-muted">
                        <a href="" class="link-info">go the original movie page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `
}


function* generateMovieCard(data) {

    for (movie of data) {

        // const url = Routing.generate('app_movies_getmoviebyid', { id: movie["id"] });
        let anchor = document.createElement("a");
        anchor.href = `/movie/${movie["id"]}`;
        anchor.textContent = 'See more...';
        anchor.classList.add("link-info");
        yield `
            <div class="col-3">
                <div class="card mb-3">
                    <img src="https://image.tmdb.org/t/p/w1280/${movie["poster_path"]}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">${movie['title']}</h5>
                        <p class="card-text">${movie['overview'].slice(0, 100)} <a class="link-info" href='${url}'>See more...</a></p>
                        <p class="card-text"><small class="text-muted">Release date: ${movie['release_date']}</small></p>
                    </div>
                </div>
            </div>    
        `
    }

}
