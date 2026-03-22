const btnDelete = document.getElementById('btn-delete');
const btnCancel = document.getElementById('btn-cancel');
const overlay = document.getElementById('modal-overlay');

btnDelete.addEventListener('click', () => {
    overlay.style.display = 'flex';
});

btnCancel.addEventListener('click', () => {
    overlay.style.display = 'none';
});

overlay.addEventListener('click', (e) => {
    if (e.target === overlay) {
        overlay.style.display = 'none';
    }
});