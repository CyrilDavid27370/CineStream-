const input = document.getElementById('search-input');
const resultsContainer = document.getElementById('search-results');
const loader = document.getElementById('search-loader');
const emptyMessage = document.getElementById('search-empty');

let debounceTimer;

input.addEventListener('input', function() {
    const query = this.value.trim();

    clearTimeout(debounceTimer);

    if (query.length < 2) {
        resultsContainer.innerHTML = '';
        emptyMessage.style.display = 'none';
        loader.style.display = 'none';
        return;
    }

    debounceTimer = setTimeout(() => {
        searchFilms(query);
    }, 400);
});

async function searchFilms(query) {
    loader.style.display = 'block';
    resultsContainer.innerHTML = '';
    emptyMessage.style.display = 'none';

    try {
        const response = await fetch(`${BASE_URL}/?route=searchApi&query=${encodeURIComponent(query)}`);
        const films = await response.json();

        loader.style.display = 'none';

        if (films.length === 0) {
            emptyMessage.style.display = 'block';
            emptyMessage.textContent = `🎬 Aucun résultat pour "${query}"`;
            return;
        }

    resultsContainer.innerHTML = films.map(film => `
    <a href="?route=showTmdb&id=${film.id}" class="search-card-link">
        <div class="search-card ${film.in_library ? 'card-in-library' : ''}">
            ${film.poster_path
                ? `<img src="${IMAGE_URL}${film.poster_path}" alt="${escapeHtml(film.title)}">`
                : `<div class="no-poster">🎥</div>`
            }
            <div class="search-card-title">${escapeHtml(film.title)}</div>
            <div class="search-card-meta">📅 ${film.release_date ? film.release_date.substring(0, 4) : 'n/c'}</div>
            ${film.in_library 
                ? `<div class="badge-library">✅ Dans ma vidéothèque</div>`
                : `<div class="badge-add">➕ Ajouter</div>`
            }
        </div>
    </a>
`).join('');

    } catch (error) {
        loader.style.display = 'none';
        emptyMessage.style.display = 'block';
        emptyMessage.textContent = '❌ Erreur lors de la recherche.';
    }
}

if (input.value.trim().length >= 2) {
    searchFilms(input.value.trim());
}