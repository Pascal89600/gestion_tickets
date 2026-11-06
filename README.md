# Gestion de tickets

Application web développée avec Symfony 7.4 dans le cadre d'un devoir de formation PHP/Symfony.

## Présentation

Cette application permet aux utilisateurs de déposer des demandes d'assistance et au personnel habilité de suivre leur traitement.

Elle propose également une interface d'administration permettant de gérer les tickets, les catégories, les états et les utilisateurs.

##  Fonctionnalités

- Création publique d'un ticket sans authentification.

- Authentification des membres du personnel.

- Consultation de la liste et du détail des tickets.

- Modification de l'état et du responsable d'un ticket.

- Gestion automatique des dates de clôture et de réouverture.

- Administration des utilisateurs, catégories et états.

- Modification complète des tickets par un administrateur.

## Prérequis techniques

L'application utilise les technologies suivantes :

- PHP 8.2 ou supérieur

- Symfony 7.4

- Composer

- MySQL ou MariaDB

- Doctrine ORM et Doctrine Migrations

- Twig

- Symfony Security

Les extensions PHP nécessaires à Symfony et au pilote de base de données doivent être activées.

## Installation

### 1. Récupérer le projet

Cloner le dépôt GitHub :
```bash
git clone https://github.com/Pascal89600/gestion_tickets.git
cd gestion_tickets
```
### 2. Installer les dépendances

```bash
composer install
```

Cette commande installe les bibliothèques PHP définies dans composer.lock, y compris les outils de développement nécessaires au chargement des fixtures.

### 3. Configurer la base de données

L'application utilise MySQL 8.

Créer un fichier .env.local à la racine du projet et y renseigner les paramètres de connexion à MySQL :
```bash
DATABASE_URL="mysql://utilisateur:mot_de_passe@127.0.0.1:3306/gestion_tickets?serverVersion=8.0.47&charset=utf8mb4"
```
Adapter le nom d'utilisateur, le mot de passe et les paramètres du serveur à l'environnement local.

### 4. Créer la base de données

```bash
php bin/console doctrine:database:create
```

### 5. Exécuter les migrations

```bash
php bin/console doctrine:migrations:migrate
```

Les migrations créent les tables nécessaires au fonctionnement de l'application.

### 6. Charger les données de démonstration
```bash
php bin/console doctrine:fixtures:load
```
Attention : cette commande purge par défaut les données existantes. Elle doit être utilisée sur une base neuve ou dédiée aux tests.

### 7. Démarrer l'application

Depuis le répertoire du projet, lancer le serveur de développement Symfony :
```bash
symfony server:start
```
Ouvrir ensuite l'adresse indiquée dans le terminal, généralement :

http://127.0.0.1:8000

La commande nécessite l'installation de Symfony CLI. Il est également possible d'utiliser un serveur web local correctement configuré pour servir le répertoire public/.

## Comptes de démonstration

Les comptes suivants sont créés lors du chargement des fixtures.

| Rôle | Identifiant | Mot de passe |
|---|---|---|
| Administrateur | admin@example.com | AdminTest2026! |
| Personnel | jean.dupont@example.com | PersonnelTest2026! |
| Personnel | sophie.martin@example.com | PersonnelTest2026! |

Ces identifiants sont réservés à l'environnement de démonstration et ne doivent pas être utilisés en production.

## Fonctionnement des tickets

Les demandes peuvent être déposées sans authentification.

Le personnel connecté peut consulter les tickets, modifier leur état et désigner un responsable.

L'administrateur dispose de fonctionnalités supplémentaires de gestion des utilisateurs, catégories, états et tickets.

Lorsqu'un ticket passe dans un état défini comme clôturant, une date de clôture est automatiquement enregistrée. Si le ticket est rouvert, cette date est supprimée.

La propriété cloturant est paramétrable par l'administrateur et ne dépend pas du nom de l'état.