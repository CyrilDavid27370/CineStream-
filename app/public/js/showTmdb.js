const btnAdd = document.getElementById('btn-add');
const toast = document.getElementById('toast');

btnAdd.addEventListener('click', async function() {
    const tmdbId = this.dataset.id;

    btnAdd.disabled = true;
    btnAdd.textContent = '⏳';

    try {
        const response = await fetch(`${BASE_URL}/?route=addFromTmdbApi&id=${tmdbId}`);
        const data = await response.json();

        showToast(data.message, data.success ? 'success' : 'warning');

        if (data.success) {
            btnAdd.textContent = '✅';
        } else {
            btnAdd.disabled = false;
            btnAdd.textContent = '➕';
        }

    } catch (error) {
        showToast('❌ Erreur lors de l\'ajout.', 'error');
        btnAdd.disabled = false;
        btnAdd.textContent = '➕';
    }
});