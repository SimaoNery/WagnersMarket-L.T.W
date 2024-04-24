let suggestionsContainer = document.querySelector("#suggestions");
let searchBarContainer = document.querySelector("#search-bar");
let inputSearch = document.querySelector("#searchitem");
let inputText = "";


if (inputSearch) {
    inputSearch.addEventListener("input", function (event) {
        inputText = event.target.value.trim();
        if (inputText.length == 0) {
            suggestionsContainer.innerHTML = "";
            return;
        }
    
        renderSuggestions(inputText);
    });
}

function renderSuggestions(suggestions) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `../api/api_suggestions.php?search=${encodeURIComponent(suggestions)}`, true);

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 400) {
            try {
                console.log(xhr.responseText);
                const response = JSON.parse(xhr.responseText);

                suggestionsContainer.innerHTML = "";
                const fragment = document.createDocumentFragment();
                
                if (response.length === 0) {
                    const noSuggestions = document.createElement("p");
                    noSuggestions.textContent = "No suggestions found.";
                    fragment.appendChild(noSuggestions);
                } else {
                    response.forEach(suggestion => {
                        const listItem = document.createElement("li");
                        listItem.classList.add("suggestionItem");

                        const suggestionLink = document.createElement("a");
                        suggestionLink.href = `../pages/item.php?id=${suggestion.itemId}`;
                        suggestionLink.classList.add("suggestion");

                        const image = document.createElement("img");
                        image.src = suggestion.image;
                        image.alt = suggestion.title;
                        image.classList.add("suggestion-image");

                        const title = document.createElement("span");
                        title.textContent = suggestion.title;
                        title.classList.add("suggestion-title");
                        
                        suggestionLink.appendChild(image);
                        suggestionLink.appendChild(title);
                        listItem.appendChild(suggestionLink);
                        fragment.appendChild(listItem);
                    });
                }

                suggestionsContainer.appendChild(fragment);
                suggestionsContainer.style.width = searchBarContainer.offsetWidth + 'px';
            } catch (error) {
                console.error("Error parsing JSON:", error);
            }
        } else {
            console.error("HTTP Error:", xhr.status);
        }
    };

    xhr.onerror = function () {
        console.error("Request failed");
    };

    xhr.send();
}

