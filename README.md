# Wiki Coaster
Bienvenue dans votre projet de développement intégré INFO 2.

## Cloner le projet Github


## Installation

### Via Docker

#### Docker et Symfony en quelques mots

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

#### Installation

Les commandes suivantes doivent être exécutées dans un terminal, depuis le
dossier principal du projet, celui qui contient le fichier `compose.yaml`.

1. Construire les images Docker :

	```bash
	docker-compose build
	```

	Cette commande lit les fichiers de configuration, notamment le
	`Dockerfile`, et prépare les images nécessaires au projet. Une image est un
	modèle utilisé pour créer un conteneur. Cette étape est généralement
	nécessaire lors de la première installation ou après une modification du
	`Dockerfile`.

2. Démarrer les conteneurs en arrière-plan :

	```bash
	docker-compose up -d
	```

	L'option `up` crée et démarre les conteneurs décrits dans `compose.yaml`.
	L'option `-d` signifie que Docker les laisse fonctionner en arrière-plan et
	redonne immédiatement la main au terminal.

3. Vérifier l'état des conteneurs :

	```bash
	docker-compose ps
	```

	Cette commande affiche les conteneurs du projet, leur état et les ports
	utilisés. Vérifiez qu'ils sont indiqués comme étant démarrés (`Up`). Le nom
	du conteneur à utiliser à l'étape suivante apparaît également dans cette
	liste.

4. Ouvrir un terminal dans le conteneur de l'application :

	```bash
	docker exec -it xxxx bash
	```

	La commande `docker exec` exécute une commande dans un conteneur déjà
	démarré. Les options `-it` permettent d'utiliser le terminal de manière
	interactive, et `bash` ouvre une console Linux dans le conteneur.

	Remplacez `xxxx` par le nom ou l'identifiant du conteneur de l'application
	affiché par `docker-compose ps`. Une fois dans le conteneur, l'invite de
	commande change généralement pour indiquer que vous êtes à l'intérieur.

5. Installer les dépendances PHP avec Composer :

	```bash
	composer install
	```

	Cette commande lit le fichier `composer.json` et télécharge les paquets PHP
	nécessaires au projet, notamment Symfony. Elle doit être exécutée dans le
	dossier du projet à l'intérieur du conteneur.

Pour quitter le conteneur et revenir au terminal de votre ordinateur, utilisez
la commande suivante :

```bash
exit
```

Les conteneurs continuent de fonctionner après cette commande. Pour les
arrêter lorsque vous avez terminé, utilisez :

```bash
docker-compose down
```

Cette commande arrête et supprime les conteneurs du projet, sans supprimer le
code source présent sur votre ordinateur.

### Sans Docker

Cette méthode installe directement sur votre ordinateur les outils nécessaires
au projet. Contrairement à Docker, les versions de PHP, Composer, Node.js et
Symfony CLI sont alors installées et utilisées par votre système.

Les commandes ci-dessous sont à exécuter dans un terminal, depuis le dossier
principal du projet.

#### 1. Installer Git et récupérer le projet

**Git** est un outil qui permet de télécharger et de suivre les versions d'un
projet. **GitHub** est un service en ligne qui héberge des dépôts Git, comme
celui de WikiCoaster.

##### Windows

Téléchargez et installez [Git for Windows](https://git-scm.com/download/win).
Pendant l'installation, les options proposées par défaut conviennent. Ouvrez
ensuite **Git Bash**, PowerShell ou l'invite de commandes.

##### Linux (Ubuntu ou Debian)

Installez Git avec le gestionnaire de paquets :

```bash
sudo apt update
sudo apt install git
```

Vérifiez que Git est disponible :

```bash
git --version
```

##### Créer un compte GitHub

Si vous n'avez pas encore de compte, rendez-vous sur
[github.com](https://github.com/), cliquez sur **Sign up** et suivez les
instructions. Une adresse e-mail est nécessaire pour créer le compte.

Le compte GitHub est nécessaire pour participer au projet. Pour cloner un
dépôt public comme celui-ci, il n'est pas nécessaire de configurer une clé SSH
ou un mot de passe GitHub.

##### Cloner le projet

Placez-vous dans le dossier où vous souhaitez enregistrer le projet, puis
exécutez :

```bash
git clone https://github.com/Oviglo/WikiCoaster.git
cd WikiCoaster
```

La commande `git clone` télécharge le dépôt et crée un dossier `WikiCoaster`.
La commande `cd WikiCoaster` entre dans ce dossier. Les commandes des étapes
suivantes doivent être exécutées à cet endroit.

##### Créer son propre dépôt GitHub

Pour travailler sur votre propre copie du projet, créez un
nouveau dépôt sur [github.com](https://github.com/) avec votre compte. Donnez-
lui un nom, par exemple `WikiCoaster`, et laissez-le vide : ne créez pas de
`README`, de fichier `.gitignore` ou de licence, car ces fichiers existent
déjà dans le projet cloné.

Dans le terminal, toujours placé dans le dossier `WikiCoaster`, remplacez
`VOTRE_NOM` par votre nom d'utilisateur GitHub et exécutez :

```bash
git remote rename origin upstream
git remote add origin https://github.com/VOTRE_NOM/WikiCoaster.git
git remote -v
git push -u origin main
```

La commande `remote rename` conserve le dépôt d'origine sous le nom
`upstream`. La commande `remote add` définit votre nouveau dépôt comme dépôt
principal, appelé `origin`. `remote -v` permet de vérifier les adresses
enregistrées. Enfin, `push` envoie le code vers votre dépôt GitHub et
`-u origin main` associe la branche locale `main` à la branche distante.

Si Git indique que votre branche s'appelle `master` au lieu de `main`, utilisez
`git push -u origin master`. GitHub peut demander une authentification lors du
premier envoi.


#### 2. Installer PHP 8.4

PHP est le langage utilisé par Symfony. La version 8.4 doit être disponible
dans le terminal avant de continuer.

##### Windows

1. Téléchargez l'archive **PHP 8.4 x64 Thread Safe** depuis le site officiel
	de PHP pour Windows : [windows.php.net/download](https://windows.php.net/download/).
2. Décompressez-la dans un dossier simple, par exemple `C:\php`.
3. Ajoutez `C:\php` à la variable d'environnement `Path` de Windows. Dans
	le menu Démarrer, recherchez **Modifier les variables d'environnement
	système**, puis ajoutez le dossier dans **Variables d'environnement**.
4. Copiez `php.ini-development` et renommez la copie `php.ini`.
5. Dans `php.ini`, activez au minimum les extensions utilisées par les
	projets Symfony en retirant le point-virgule au début des lignes suivantes :

	```ini
	extension=curl
	extension=mbstring
	extension=openssl
	extension=pdo_mysql
	extension=zip
	```

	Selon la base de données utilisée par le projet, `pdo_pgsql` peut remplacer
	ou compléter `pdo_mysql`.

##### Linux (Ubuntu ou Debian)

Sur une distribution récente, le dépôt officiel peut proposer PHP 8.4. Si ce
n'est pas le cas, utilisez le dépôt maintenu par **Ondrej Surý** :

```bash
sudo apt update
sudo apt install software-properties-common ca-certificates lsb-release apt-transport-https
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php8.4 php8.4-cli php8.4-common php8.4-curl php8.4-mbstring php8.4-xml php8.4-intl php8.4-mysql php8.4-zip unzip
```

Si le projet utilise PostgreSQL, installez également `php8.4-pgsql` à la place
ou en complément de `php8.4-mysql`.

Vérifiez ensuite la version installée :

```bash
php --version
```

La première ligne doit commencer par `PHP 8.4`.

#### 3. Installer Composer

Composer est le gestionnaire de dépendances PHP. Il lit le fichier
`composer.json` et télécharge les bibliothèques nécessaires à Symfony.

##### Windows

Téléchargez et exécutez l'installateur officiel
[`Composer-Setup.exe`](https://getcomposer.org/download/). Il détecte
normalement PHP automatiquement. Fermez puis rouvrez le terminal après
l'installation.

##### Linux

Exécutez l'installateur officiel, puis rendez Composer disponible dans le
chemin système :

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
rm composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
```

Vérifiez l'installation :

```bash
composer --version
```

#### 4. Installer Node.js et NPM

Node.js permet d'exécuter des outils JavaScript. **NPM** est installé avec
Node.js et sert notamment à télécharger les dépendances front-end du projet.

##### Windows et Linux

Téléchargez la version **LTS** depuis [nodejs.org](https://nodejs.org/), puis
suivez l'installateur correspondant à votre système. Sous Linux, vous pouvez
également utiliser `nvm` (Node Version Manager) pour installer une version LTS.

Vérifiez les deux commandes :

```bash
node --version
npm --version
```

Si le projet contient un fichier `package.json`, installez ses dépendances
depuis le dossier du projet :

```bash
npm install
```

Cette étape crée généralement le dossier `node_modules`. Si aucun fichier
`package.json` n'est présent, cette commande n'est pas nécessaire.

#### 5. Installer Symfony CLI

Symfony CLI est un outil en ligne de commande qui fournit notamment un serveur
de développement local. Il ne remplace pas Symfony : il aide à lancer et à
tester une application Symfony.

##### Windows

Téléchargez l'installateur Windows depuis
[symfony.com/download](https://symfony.com/download), exécutez-le, puis
ouvrez un nouveau terminal.

##### Linux

Installez Symfony CLI avec la commande officielle :

```bash
wget https://get.symfony.com/cli/installer -O - | bash
```

Ajoutez ensuite le dossier d'installation au `PATH` si l'installateur vous le
demande. Dans un nouveau terminal, vérifiez l'installation :

```bash
symfony version
```

#### 6. Installer et lancer le projet

Après l'installation des outils, exécutez Composer depuis le dossier du projet
pour télécharger les dépendances PHP :

```bash
composer install
```

Lancez ensuite le serveur Symfony :

```bash
symfony server:start
```

Symfony affiche l'adresse locale du projet, généralement
`https://127.0.0.1:8000`. Ouvrez cette adresse dans un navigateur. Pour arrêter
le serveur, utilisez `Ctrl+C` dans le terminal.
