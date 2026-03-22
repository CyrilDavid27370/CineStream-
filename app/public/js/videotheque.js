let allFilms = [];

async function loadFilms() {
    const container = document.getElementById('films-container');

    container.innerHTML = `
        <div class="films-loader">
            <span></span><span></span><span></span>
        </div>
    `;

    try {
        const response = await fetch(BASE_URL + '/?route=filmsApi');
        allFilms = await response.json();
        renderFilms(allFilms);
    } catch (error) {
        console.error('Erreur chargement films:', error);
    }
}

function renderFilms(films) {
    const container = document.getElementById('films-container');
    const emptyMessage = document.getElementById('empty-message');

    if (films.length === 0) {
        container.innerHTML = '';
        emptyMessage.style.display = 'block';
        return;
    }

    emptyMessage.style.display = 'none';
    container.innerHTML = films.map((film, index) => `
        <a href="?route=show&id=${film.id}" class="card-link" style="animation-delay: ${index * 0.05}s">
            <div class="card">
                ${film.poster_path
                    ? `<img src="${IMAGE_URL}${film.poster_path}" alt="${escapeHtml(film.title)}">`
                    : `<div class="no-poster">🎥</div>`
                }
                <p class="card-title">${escapeHtml(film.title)}</p>
                <p class="card-meta">📅 ${film.release_date ?? 'n/c'} ${film.isWatched ? '👁️' : '🕒'}</p>
            </div>
        </a>
    `).join('');
}

function filterFilms(btn) {
    document.querySelectorAll('.filters button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const filter = btn.dataset.filter;
    const genreId = btn.dataset.genreId;

    let filtered = allFilms;

    if (filter === 'genre') {
        filtered = allFilms.filter(f => f.genre_id == genreId);
    } else if (filter === 'nc') {
        filtered = allFilms.filter(f => f.genre_id === null);
    } else if (filter === 'watched') {
        filtered = allFilms.filter(f => f.isWatched == 1);
    } else if (filter === 'towatch') {
        filtered = allFilms.filter(f => f.isWatched == 0);
    }

    renderFilms(filtered);
}

document.querySelectorAll('.filters button').forEach(btn => {
    btn.addEventListener('click', () => filterFilms(btn));
});

document.getElementById('btn-grid').addEventListener('click', function() {
    document.getElementById('films-container').classList.remove('list-view');
    document.getElementById('btn-grid').classList.add('active');
    document.getElementById('btn-list').classList.remove('active');
});

document.getElementById('btn-list').addEventListener('click', function() {
    document.getElementById('films-container').classList.add('list-view');
    document.getElementById('btn-list').classList.add('active');
    document.getElementById('btn-grid').classList.remove('active');
});

loadFilms();