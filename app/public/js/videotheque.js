let allFilms = [];
let currentPage = 1;
let currentFilter = 'all';
let currentGenreId = null;

async function loadFilms(page = 1) {
    const container = document.getElementById('films-container');

    container.innerHTML = `
        <div class="films-loader">
            <span></span><span></span><span></span>
        </div>
    `;

    let url = `${BASE_URL}/?route=filmsApi&page=${page}`;
    if (currentGenreId === 'nc') {
        url += `&genre=nc`;
    } else if (currentGenreId) {
        url += `&genre=${currentGenreId}`;
    } else if (currentFilter !== 'all') {
        url += `&filter=${currentFilter}`;
    }

    try {
        const response = await fetch(url);
        const result = await response.json();

        currentPage = result.page;
        renderFilms(result.films);
        renderPagination(result.page, result.totalPages, result.total);
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
        document.getElementById('pagination').innerHTML = '';
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

function renderPagination(page, totalPages, total) {
    const pagination = document.getElementById('pagination');

    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }

    let html = `<div class="pagination-info">${total} film(s)</div><div class="pagination-buttons">`;

    // Bouton précédent
    html += `<button class="btn-page ${page === 1 ? 'disabled' : ''}" 
        ${page === 1 ? 'disabled' : `onclick="loadFilms(${page - 1})"`}>←</button>`;

    // Boutons de pages
    for (let i = 1; i <= totalPages; i++) {
        html += `<button class="btn-page ${i === page ? 'active' : ''}" 
            onclick="loadFilms(${i})">${i}</button>`;
    }

    // Bouton suivant
    html += `<button class="btn-page ${page === totalPages ? 'disabled' : ''}" 
        ${page === totalPages ? 'disabled' : `onclick="loadFilms(${page + 1})"`}>→</button>`;

    html += `</div>`;
    pagination.innerHTML = html;
}

function filterFilms(btn) {
    document.querySelectorAll('.filters button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const filter = btn.dataset.filter;
    const genreId = btn.dataset.genreId;

    currentFilter = filter;
    currentGenreId = genreId || null;

    if (filter === 'genre') {
        currentGenreId = genreId;
        currentFilter = 'all';
    } else if (filter === 'nc') {
        currentGenreId = 'nc';
        currentFilter = 'all';
    } else {
        currentGenreId = null;
    }

    loadFilms(1);
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

loadFilms(1);