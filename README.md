# 🖥️ Data Center - Gestion des Ressources

Application web de gestion des ressources d'un Data Center développée avec Laravel. Ce projet permet la gestion centralisée des équipements informatiques, des réservations, et des incidents.

## 📋 Présentation du Projet

Cette application a été conçue pour faciliter la gestion quotidienne d'un Data Center en offrant :

- **Gestion des Ressources** : Création et suivi des équipements (serveurs, switches, etc.)
- **Catégories de Ressources** : Organisation par catégories pour une meilleure classification
- **Système de Réservation** : Réservation des ressources avec détection automatique des conflits
- **Gestion des Incidents** : Signalement et suivi des problèmes techniques
- **Système de Rôles** : Accès différenciés selon le rôle (Admin, Manager, User, Guest)

## 🛠️ Technologies Utilisées

- **Backend** : Laravel 8.x (PHP 7.3+)
- **Frontend** : Blade Templates + CSS + JavaScript Vanilla
- **Base de données** : MySQL/MariaDB
- **Authentification** : Laravel Breeze
- **Build Tools** : Vite, Webpack Mix


## 📦 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- PHP 7.3 ou supérieur
- Composer
- Node.js et npm
- MySQL 5.7+ ou MariaDB
- Git

## ⚙️ Installation et Configuration

### 1. Cloner le projet

```bash
git clone https://github.com/Yaasinayadi/laravel_miniProjet.git
cd laravel_miniProjet/projet
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances Node.js

```bash
npm install
```

### 4. Configuration de l'environnement

Copiez le fichier d'environnement exemple :

```bash
cp .env.example .env
```

Générez la clé d'application :

```bash
php artisan key:generate
```

### 5. Configuration de la base de données

Ouvrez le fichier `.env` et configurez vos paramètres de base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=datacenter
DB_USERNAME=root
DB_PASSWORD=
```

Créez la base de données :

```bash
mysql -u root -p
CREATE DATABASE datacenter;
EXIT;
```

### 6. Exécuter les migrations

```bash
php artisan migrate
```

### 7. (Optionnel) Remplir la base avec des données de test

```bash
php artisan db:seed
```

### 8. Compiler les assets frontend

Pour le développement :

```bash
npm run dev
```

Pour la production :

```bash
npm run build
```

### 9. Lancer l'application

```bash
php artisan serve
```

L'application sera accessible à l'adresse : **http://localhost:8000**

## 👥 Fonctionnalités par Rôle

| Rôle | Permissions |
|------|-------------|
| **Admin** | Gestion complète du système, utilisateurs, ressources, et configuration |
| **Manager** | Gestion des ressources, validation des réservations |
| **User** | Consultation et réservation des ressources, signalement d'incidents |
| **Guest** | Accès en lecture seule aux ressources disponibles |

## 📁 Structure du Projet

Le projet suit l'architecture MVC de Laravel :

- `app/Models/` : Modèles Eloquent (User, Resource, Category, Reservation, Incident)
- `app/Http/Controllers/` : Contrôleurs pour la logique métier
- `resources/views/` : Templates Blade pour l'interface utilisateur
- `database/migrations/` : Fichiers de migration pour la structure de la base de données
- `routes/web.php` : Définition des routes de l'application

## 🎥 Démonstration Vidéo

Une démonstration complète du projet est disponible ici :
[Voir la vidéo de démonstration](https://drive.google.com/drive/folders/1TQsqFKDx6sdFPuk94T2n-pWhkn5Q9XpM?usp=drive_link)

## 👨‍💻 Contributeurs

Ce projet a été développé par l'équipe suivante dans le cadre du module de développement web :

- **CHRIAA Zakariae**
- **AYADI Yassine**
- **JABIR Oussama**
- **ABAKAR MOUSSA Hamit**

## 📄 Documentation Complémentaire

Pour plus de détails sur l'architecture et les fonctionnalités du projet, consultez le rapport complet dans le dossier `rapport/`.


