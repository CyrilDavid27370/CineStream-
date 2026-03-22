<?php

namespace Cine\App\Controller;

use Cine\App\Repository\UserRepository;
use Cine\App\Repository\FilmRepository;

class AdminController
{
    private UserRepository $userRepository;
    private FilmRepository $filmRepository;

    public function __construct()
    {
        // Vérifie que l'utilisateur est admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ?route=index');
            exit;
        }

        $this->userRepository = new UserRepository();
        $this->filmRepository = new FilmRepository();
    }

    public function users(): void
    {
        $users = $this->userRepository->findAll();

        // Pour chaque user, récupère ses stats
        $stats = [];
        foreach ($users as $user) {
            $stats[$user->getId()] = [
                'total'   => $this->filmRepository->countByUser($user->getId()),
                'watched' => $this->filmRepository->countWatchedByUser($user->getId()),
                'towatch' => $this->filmRepository->countToWatchByUser($user->getId()),
            ];
        }

        require __DIR__ . '/../view/admin/users.phtml';
    }

    public function userFilms(): void
    {
        $userId = (int)$_GET['id'];
        $user   = $this->userRepository->findById($userId);

        if (!$user) {
            header('Location: ?route=adminUsers');
            exit;
        }

        $films = $this->filmRepository->findAllByUser($userId);

        require __DIR__ . '/../view/admin/userFilms.phtml';
    }

    public function deleteUser(): void
    {
        $userId = (int)$_GET['id'];

        // Supprime d'abord les films
        $this->filmRepository->deleteByUser($userId);

        // Supprime le compte
        $this->userRepository->delete($userId);

        $_SESSION['flash'] = '✅ Utilisateur supprimé avec succès.';
        header('Location: ?route=adminUsers');
        exit;
    }
}