const btnDeleteAccount = document.getElementById('btn-delete-account');
const btnCancelDelete = document.getElementById('btn-cancel-delete');
const modalDeleteAccount = document.getElementById('modal-delete-account');

btnDeleteAccount.addEventListener('click', () => {
    modalDeleteAccount.style.display = 'flex';
});

btnCancelDelete.addEventListener('click', () => {
    modalDeleteAccount.style.display = 'none';
});

modalDeleteAccount.addEventListener('click', (e) => {
    if (e.target === modalDeleteAccount) {
        modalDeleteAccount.style.display = 'none';
    }
});