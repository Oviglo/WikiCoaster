# Mémo de commandes

Les commandes Docker sont à exécuter depuis le dossier `WikiCoaster`, qui
contient le fichier `compose.yaml`. Les commandes Composer, NPM et Symfony
s'exécutent dans le conteneur PHP après :

```bash
docker exec -it wcoaster-php bash
```

## Git

```bash
git status
git add .
git commit -m "Votre message de commit"
git push
git pull
git branch
git switch NOM_DE_LA_BRANCHE
git switch -c NOM_DE_LA_NOUVELLE_BRANCHE
git log --oneline
```

- `git status` affiche les fichiers modifiés et l'état du dépôt.
- `git add .` prépare toutes les modifications pour le prochain commit.
- `git commit -m` enregistre les modifications avec un message.
- `git push` envoie les commits vers le dépôt distant.
- `git pull` récupère et applique les modifications du dépôt distant.
- `git branch` affiche les branches locales.
- `git switch` change de branche ; l'option `-c` crée une branche avant de s'y
	placer.
- `git log --oneline` affiche un historique compact des commits.

## Docker

```bash
docker-compose up -d --build
docker-compose ps
docker-compose down
docker-compose logs -f
docker exec -it wcoaster-php bash
```

- `docker-compose up -d --build` construit les images et démarre les
	conteneurs en arrière-plan.
- `docker-compose ps` affiche l'état des conteneurs du projet.
- `docker-compose down` arrête et supprime les conteneurs.
- `docker-compose logs -f` affiche les journaux en continu ; utilisez
	`Ctrl+C` pour arrêter l'affichage.
- `docker exec -it wcoaster-php bash` ouvre un terminal dans le conteneur PHP.

## Composer

```bash
composer install
composer update
composer require NOM_DU_PAQUET
composer require --dev NOM_DU_PAQUET
```

- `composer install` installe les dépendances définies par le projet.
- `composer update` met à jour les dépendances autorisées par `composer.json`.
- `composer require` ajoute une dépendance de production.
- `composer require --dev` ajoute une dépendance de développement.

## NPM

```bash
npm install
npm run dev
```

- `npm install` installe les dépendances JavaScript du projet.
- `npm run dev` compile les ressources frontend pour le développement.

## Symfony

```bash
php bin/console make:entity
php bin/console make:migration
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
php bin/console debug:router
php bin/console cache:clear
```

- `make:entity` crée ou modifie une entité Doctrine de manière interactive.
- `make:migration` crée un fichier de migration vide à compléter manuellement.
- `doctrine:migrations:diff` génère une migration à partir des changements
	apportés aux entités.
- `doctrine:migrations:migrate` applique les migrations à la base de données.
- `debug:router` affiche toutes les routes de l'application.
- `cache:clear` vide et reconstruit le cache Symfony.
