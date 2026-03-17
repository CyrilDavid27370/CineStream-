# 🎬 CinéStream +

> Votre cinéma, partout, à tout moment.

CinéStream+ est une application de vidéothèque personnelle développée en PHP (architecture MVC) permettant de gérer sa collection de films et d’en rechercher via l’API TMDB.

L’utilisateur peut :

 . rechercher des films

 . les importer dans sa vidéothèque

 . les classer par catégories

 . les noter

 . filtrer sa collection

 . regarder la bande-annonce directement dans la fiche film.

## 🛠️ Stack technique

- **PHP 8** — Architecture MVC maison
- **MySQL 8** — Base de données
- **Nginx** — Serveur web
- **Docker / Docker Compose** — Environnement de développement
- **Composer** — Autoloading PSR-4
- **API TMDB** — Recherche et import de films

## 📁 Architecture du projet

CINESTREAM/
├── app/
│   ├── public/
│   │   ├── css/
│   │   │   └── style.css
│   │   └── index.php          # Routeur principal
│   │
│   └── src/
│       ├── Controller/
│       │   └── MovieController.php
│       │
│       ├── Entity/
│       │   ├── Film.php
│       │   └── Genre.php
│       │
│       ├── Repository/
│       │   ├── Repository.php
│       │   ├── FilmRepository.php
│       │   └── GenreRepository.php
│       │
│       ├── Service/
│       │   └── Tmdb/
│       │       └── Tmdb.php
│       │
│       └── view/
│           ├── _shared/
│           │   ├── _header.phtml
│           │   └── _nav.phtml
│           │
│           ├── films/
│           │   ├── index.phtml
│           │   ├── search.phtml
│           │   ├── show.phtml
│           │   ├── showTmdb.phtml
│           │   └── update.phtml
│           │
│           ├── genres/
│           │   ├── create.phtml
│           │   ├── index.phtml
│           │   └── update.phtml
│           │
│           └── base.phtml
│
├── vendor/
├── .env.php
├── composer.json
├── docker/
├── docker-compose.yml
├── .gitignore
└── README.md

## ⚙️ Installation

### Prérequis

- Docker Desktop installé
- Composer installé

### Étapes

1. **Cloner le projet**
bash
git clone https://github.com/votre-repo/CineStream.git
cd CineStream


2. **Installer les dépendances**
bash
cd app
composer install


3. **Configurer les variables d'environnement**

Dans `app/.env.php` :
php
<?php
define('TMDB_API_KEY', 'votre_clé_api_tmdb');
define('TMDB_BASE_URL', 'https://api.themoviedb.org/3');
define('TMDB_IMAGE_URL', 'https://image.tmdb.org/t/p/w500');
$API_KEY = TMDB_API_KEY;
```

4. **Lancer les conteneurs Docker**
bash
docker-compose up -d

5. **Accéder à l'application**

- Application : [http://localhost:8080](http://localhost:8080)
- phpMyAdmin : [http://localhost:8081](http://localhost:8081)


## 🗄️ Base de données

### Tables

**genre**
| Colonne | Type |
|---------|------|
| id | INT AUTO_INCREMENT |
| name | VARCHAR(100) |

**film**
| Colonne | Type |
|---------|------|
| id | INT AUTO_INCREMENT |
| tmdb_id | INT |
| title | VARCHAR(255) |
| poster_path | VARCHAR(255) |
| release_date | YEAR |
| runtime | INT |
| overview | TEXT |
| genre_id | INT (FK) |
| description | TEXT |
| isWatched | TINYINT(1) |
| rating | INT |    

## 🚀 Fonctionnalités principales

- 📋 **Vidéothèque** — Affichage de tous les films en grille
- 🔍 **Filtres** — Par genre, films vus, films à voir
- 🎬 **Fiche film** — Détail complet d'un film
- ✏️ **Modification** — Genre, note personnelle, statut vu/à voir
- 🗑️ **Suppression** — Avec confirmation JavaScript
- 🔎 **Recherche TMDB** — Recherche par titre via l'API
- ➕ **Ajout** — Import d'un film depuis TMDB vers la vidéothèque

## 🚀 Fonctionnalités V2 (Bonus)

- 🔲 **Choix de l'affichage** — Affichage de tous les films en vue grille ou en vue liste
- ⭐ **Notation personnelle** — Système de notation par étoiles (1 à 10)
- 🏷️ **Gestion des catégories personnaliséés** — CRUD complet des catégories
- ▶️ **Lecteur de bande-annonce** — affichage de la bande-annonce YouTube depuis TMDB

## 📱 Responsive

Interface développée en mobile first.

- **Mobile** : 1 colonne
- **Tablette** (480px+) : 2 colonnes
- **Desktop** (768px+) : 3 colonnes

🧠 Compétences mobilisées

 - Architecture MVC

 - POO en PHP

 -  CRUD complet

 - API REST (TMDB)

 - Dockerisation d’une application

 - Responsive design

 - Autoload PSR-4 (Composer)

## 👨‍💻 Auteur

**Cyril DAVID** — Formation DWWM — Hunik Academy  
Projet réalisé dans le cadre du titre professionnel Développeur Web et Web Mobile (niveau 5).