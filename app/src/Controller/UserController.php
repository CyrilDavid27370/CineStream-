<?php

namespace Cine\App\Controller;

use Cine\App\Repository\UserRepository;
use Cine\App\Repository\FilmRepository;

class UserController
{
    private UserRepository $userRepository;
    private FilmRepository $filmRepository;
    private int $userId;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->filmRepository = new FilmRepository();
        $this->userId = (int)$_SESSION['user_id'];
    }

    public function profile(): void
    {
        $user = $this->userRepository->findById($this->userId);
        $totalFilms   = $this->filmRepository->countByUser($this->userId);
        $watchedFilms = $this->filmRepository->countWatchedByUser($this->userId);
        $toWatchFilms = $this->filmRepository->countToWatchByUser($this->userId);

        $emailError    = null;
        $emailSuccess  = null;
        $passwordError   = null;
        $passwordSuccess = null;

        // Changement d'email
        if (isset($_POST['action']) && $_POST['action'] === 'email') {
            $newEmail = trim($_POST['email'] ?? '');

            if (empty($newEmail)) {
                $emailError = 'L\'email ne peut pas être vide.';
            } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                $emailError = 'Adresse email invalide.';
            } elseif ($this->userRepository->findByEmail($newEmail)) {
                $emailError = 'Cette adresse email est déjà utilisée.';
            } else {
                $this->userRepository->updateEmail($this->userId, $newEmail);
                $_SESSION['user_email'] = $newEmail;
                $emailSuccess = '✅ Email modifié avec succès !';
                $user = $this->userRepository->findById($this->userId);
            }
        }

        // Changement de mot de passe
        if (isset($_POST['action']) && $_POST['action'] === 'password') {
            $current  = $_POST['current_password'] ?? '';
            $new      = $_POST['new_password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';

            if (empty($current) || empty($new) || empty($confirm)) {
                $passwordError = 'Tous les champs sont obligatoires.';
            } elseif (!password_verify($current, $user->getPassword())) {
                $passwordError = 'Mot de passe actuel incorrect.';
            } elseif (strlen($new) < 8) {
                $passwordError = 'Le nouveau mot de passe doit contenir au moins 8 caractères.';
            } elseif ($new !== $confirm) {
                $passwordError = 'Les mots de passe ne correspondent pas.';
            } else {
                $this->userRepository->updatePassword($this->userId, password_hash($new, PASSWORD_DEFAULT));
                $passwordSuccess = '✅ Mot de passe modifié avec succès !';
            }
        }

        require __DIR__ . '/../view/user/profile.phtml';
    }

    public function deleteAccount(): void
    {
        // Supprime tous les films de l'utilisateur d'abord
        $this->filmRepository->deleteByUser($this->userId);

        // Supprime le compte
        $this->userRepository->delete($this->userId);

        // Détruit la session
        session_destroy();

        header('Location: ?route=login');
        exit;
    }
}