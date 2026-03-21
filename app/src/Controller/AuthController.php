<?php

namespace Cine\App\Controller;

use Cine\App\Repository\UserRepository;

class AuthController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function login(): void
    {
        // Si déjà connecté, on redirige directement
        if (isset($_SESSION['user_id'])) {
            header('Location: ?route=index');
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->userRepository->findByEmail($email);

            if ($user && password_verify($password, $user->getPassword())) {
                $_SESSION['user_id']    = $user->getId();
                $_SESSION['user_email'] = $user->getEmail();
                $_SESSION['user_role']  = $user->getRole();

                header('Location: ?route=index');
                exit;
            }

            $error = 'Email ou mot de passe incorrect.';
        }

        require __DIR__ . '/../view/user/login.phtml';
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: ?route=login');
        exit;
    }

    public function register(): void
{
    // Si déjà connecté, on redirige
    if (isset($_SESSION['user_id'])) {
        header('Location: ?route=index');
        exit;
    }

    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email     = trim($_POST['email'] ?? '');
        $password  = trim($_POST['password'] ?? '');
        $confirm   = trim($_POST['confirm'] ?? '');

        // Validations
        if (empty($email) || empty($password) || empty($confirm)) {
            $error = 'Tous les champs sont obligatoires.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Adresse email invalide.';
        } elseif (strlen($password) < 8) {
            $error = 'Le mot de passe doit contenir au moins 8 caractères.';
        } elseif ($password !== $confirm) {
            $error = 'Les mots de passe ne correspondent pas.';
        } elseif ($this->userRepository->findByEmail($email)) {
            $error = 'Cette adresse email est déjà utilisée.';
        } else {
            $this->userRepository->create($email, password_hash($password, PASSWORD_DEFAULT));
            $_SESSION['flash'] = '✅ Compte créé avec succès ! Connectez-vous.';
            header('Location: ?route=login');
            exit;
        }
    }

    require __DIR__ . '/../view/user/register.phtml';
}
}