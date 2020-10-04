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
    link.href = `/movie/details/${id}`
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
