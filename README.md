# Transit Management

Application Laravel pour la gestion des dossiers, documents, messages et notifications.

## Description

Ce dépôt contient une application Laravel conçue pour gérer des dossiers, des documents associés, un historique d'actions, et un système de messages/notifications. L'architecture utilise des Models, Observers et Notifications pour organiser la logique métier.

## Fonctionnalités

- Gestion des utilisateurs (inscription, rôles basiques)
- Gestion des dossiers et des documents
- Historique des actions (`Historique`)
- Messagerie interne et notifications
- Observers pour automatiser les traitements métiers

## Prérequis

- PHP >= 8.1
- Composer
- Node.js (>= 16) & npm / pnpm
- Base de données compatible (MySQL, MariaDB, PostgreSQL, SQLite)

## Installation rapide

1. Cloner le dépôt

```bash
git clone <votre-repo-url>
cd transit-management
```

2. Installer les dépendances PHP

```bash
composer install
```

3. Copier et configurer l'environnement

```bash
cp .env.example .env
# Éditez .env pour configurer DB, MAIL et autres valeurs
```

4. Générer la clé d'application

```bash
php artisan key:generate
```

5. Installer et compiler les assets front-end

```bash
npm install
npm run dev
# ou pour la production
npm run build
```

6. Lancer les migrations et seeders (si nécessaire)

```bash
php artisan migrate
php artisan db:seed # optionnel
```

7. Lancer le serveur local

```bash
php artisan serve
```

## Variables d'environnement importantes

- `APP_NAME`, `APP_URL`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`

## Exemples d'utilisation

- Accéder au tableau de bord client : `/client` (selon routes)
- Accéder aux pages administratives : `/admin` (selon rôle)

## Tests

Exécuter les tests PHPUnit :

```bash
php artisan test
```


## Contact

Email: nour.ouzdouu@gmail.com
