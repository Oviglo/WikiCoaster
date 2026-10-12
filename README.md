# Wiki Coaster
Bienvenue dans votre projet de développement intégré INFO 2.

## Installation
Si votre machine n'a pas la puissance requise pour faire tourner Docker, choisissez plutôt une installation sans Docker.

- [Installation sur Windows](doc/installWindows.md)
- [Installation sur Windows sans Docker](doc/installWindowsWithoutDocker.md) 

## Docker et Symfony en quelques mots

**Docker** permet d'exécuter une application dans un conteneur. Un conteneur
regroupe l'application et les outils dont elle a besoin, par exemple PHP,
Apache et une base de données. Ainsi, tous les membres du projet utilisent un
environnement identique, sans devoir installer chacun de ces outils
directement sur son ordinateur.

Le fichier `compose.yaml` décrit les conteneurs nécessaires au projet et la
façon dont ils doivent fonctionner. **Docker Compose** lit ce fichier et
permet de démarrer plusieurs conteneurs avec une seule commande.

**Symfony** est un framework PHP : il fournit une structure et des outils pour
développer une application web. La commande `composer install` installe les
bibliothèques PHP utilisées par Symfony et par le projet.

## Structure d'un projet

Lors de la création d'un projet, Symfony ajoute une structure composée des dossiers suivants :

- **`assets`** : Contient les fichiers SCSS, JS et images de l'application. Webpack les compacte ensuite pour créer des fichiers mis dans le dossier `public`.

- **`bin`** : Contient des applications utiles pour le développement comme la console.

- **`config`** : La configuration de l'application se fait dans ce dossier, il contient principalement des fichiers YAML.

- **`public`** : Contient le fichier `index.php` ainsi que les assets générés par Webpack.

- **`src`** : Le dossier source contient le code PHP de l'application (contrôleurs, entités, formulaires, etc.).

- **`templates`** : La partie "vue" de l'application, il contient tous les fichiers de template générés par le moteur Twig.

- **`tests`** : Contient les tests fonctionnels ou unitaires de l'application.

- **`translations`** : Symfony possède un outil pour traduire une application. Les traductions sont placées dans ce dossier sous forme de fichiers YAML.

- **`var`** : Contient les fichiers de cache et de log.

- **`migrations`** : utilisé par Doctrine (l'ORM de Symfony) pour gérer les modifications de la base de données. Il contient des fichiers PHP qui décrivent les changements structurels à apporter à la base de données.

### Dossier src

Tous les fichiers PHP dans ce dossier doivent avoir un espace de nom commençant par `App`.

- **`Controller`** : Les contrôleurs ont des méthodes appelées pour chacune des pages de l'application. Ces méthodes retournent une réponse serveur (HTML, JSON, PDF, fichier, etc.).

- **`Entity`** : Les entités représentent la base de données sous forme d'objet PHP.

- **`Repository`** : Les repositories sont des classes qui permettent de lire dans la base de données. Elles contiennent les requêtes.

- **`Form`** : Les formulaires de l'application sont décrits dans ce dossier.