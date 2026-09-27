# Installation sur Windows sans Docker

## Prérequis

Avant de commencer, assurez-vous d'avoir un accès administrateur sur votre machine Windows.

## 1. Installation de PHP

### Télécharger PHP

1. Rendez-vous sur le site officiel : https://www.php.net/downloads
2. Téléchargez la dernière version stable de PHP (version 8.0 ou supérieure recommandée)
3. Choisissez la version "Thread Safe" pour Windows (fichier ZIP)

### Installer PHP

1. Créez un dossier `C:\php` sur votre machine
2. Décompressez le fichier PHP téléchargé dans ce dossier
3. Naviguez vers `C:\php` et vérifiez que vous y trouvez les fichiers PHP

### Alternative : Utiliser un installateur PHP

Vous pouvez également utiliser un installateur automatique comme :
- **PHP for Windows** : https://windows.php.net/
- **XAMPP** (inclut PHP, Apache, MySQL, etc.)
- **Laragon** (léger et facile à configurer)

## 2. Configuration des Variables d'Environnement

### Ajouter PHP au PATH

1. Appuyez sur `Win + X` et sélectionnez "Système"
2. Cliquez sur "Paramètres système avancés"
3. Cliquez sur le bouton "Variables d'environnement"
4. Sous "Variables utilisateur" ou "Variables système", cliquez sur "Nouveau"
5. Entrez :
   - **Nom de la variable** : `PHP_PATH`
   - **Valeur de la variable** : `C:\php`
6. Cliquez sur "OK"

### Modifier le PATH

1. Dans la même fenêtre "Variables d'environnement", sélectionnez la variable `Path`
2. Cliquez sur "Modifier"
3. Cliquez sur "Nouveau"
4. Ajoutez : `C:\php`
5. Cliquez sur "OK" pour valider

## 3. Configuration du fichier php.ini

1. Naviguez vers le dossier `C:\php`
2. Renommez le fichier `php.ini-development` ou `php.ini-production` en `php.ini`
3. Ouvrez le fichier `php.ini` avec un éditeur de texte

## 4. Activation des Extensions Nécessaires pour Symfony

Symfony et ses dépendances nécessitent plusieurs extensions PHP. Dé-commentez les lignes suivantes dans `php.ini` (supprimez le `;` au début) :

```ini
; Extensions recommandées pour Symfony

; PDO (Database abstraction layer) - Obligatoire
extension=pdo_mysql
extension=pdo_pgsql
extension=pdo_sqlite

; XML (traitement de fichiers XML)
extension=xml
extension=simplexml
extension=dom

; JSON (manipulation de données JSON)
extension=json

; Compression (gestion des fichiers compressés)
extension=zlib
extension=bz2

; Expressions régulières
extension=pcre

; Cryptographie et sécurité
extension=openssl

; Curl (requêtes HTTP)
extension=curl

; Filtres et validation
extension=filter

; Gestion de la mémoire
extension=mbstring

; Traitement des images (optionnel)
extension=gd

; Compression ZIP
extension=zip

; Multibyte string
extension=mbstring
```

### Localiser l'extension_dir

Assurez-vous que le chemin `extension_dir` dans `php.ini` pointe vers le bon dossier :

```ini
extension_dir = "C:\php\ext"
```

## 5. Installation de Composer

Composer est le gestionnaire de dépendances PHP, essentiel pour Symfony.

### Télécharger et Installer Composer

1. Téléchargez l'installateur depuis : https://getcomposer.org/download/
2. Exécutez l'installateur (fichier `.exe`)
3. Suivez les instructions de l'assistant d'installation
4. Choisissez le dossier PHP (`C:\php`) lors de l'installation
5. L'installateur ajoutera automatiquement Composer au PATH

### Vérifier l'Installation de Composer

Ouvrez une nouvelle invite de commande et exécutez :

```bash
composer --version
```

Vous devriez voir la version de Composer :

```
Composer version 2.x.x
```

## 6. Installation de Node.js et NPM

Node.js est nécessaire pour gérer les dépendances frontend (CSS, JavaScript) avec NPM.

### Télécharger et Installer Node.js

1. Rendez-vous sur : https://nodejs.org/
2. Téléchargez la version LTS (Long Term Support) recommandée
3. Exécutez le fichier d'installation (`.msi`)
4. Suivez l'assistant d'installation en acceptant les options par défaut
5. L'installateur ajoutera automatiquement Node.js et NPM au PATH

### Vérifier l'Installation de Node.js et NPM

Ouvrez une nouvelle invite de commande et exécutez :

```bash
node -v
```

Vous devriez voir la version de Node.js :

```
v18.x.x
```

Vérifiez également NPM :

```bash
npm -v
```

Vous devriez voir la version de NPM :

```
9.x.x
```

## 7. Installation de Symfony CLI

Symfony CLI est un outil en ligne de commande officiel qui facilite le développement avec Symfony.

### Télécharger et Installer Symfony CLI

1. Rendez-vous sur : https://symfony.com/download
2. Téléchargez le fichier pour Windows (`.exe`)
3. Exécutez le fichier téléchargé
4. L'outil s'ajoutera automatiquement au PATH

### Alternative : Installer via Scoop

Si vous avez Scoop installé sur votre machine :

```bash
scoop install symfony-cli
```

### Vérifier l'Installation de Symfony CLI

Ouvrez une nouvelle invite de commande et exécutez :

```bash
symfony -v
```

ou

```bash
symfony --version
```

Vous devriez voir la version de Symfony CLI :

```
Symfony CLI version 5.x.x
```

## 8. Vérification de l'Installation de PHP

Ouvrez une nouvelle invite de commande (Command Prompt) ou PowerShell et exécutez :

```bash
php -v
```

Vous devriez voir la version de PHP et les informations de configuration, par exemple :

```
PHP 8.2.0 (cli) (built: Dec  6 2022 15:43:38) (Thread-Safe)
Copyright (c) The PHP Group
Zend Engine v4.2.0, Copyright (c) Zend Technologies
```

## 9. Installation du Projet Symfony

1. Naviguez vers le dossier où vous souhaitez installer le projet :

```bash
cd C:\chemin\vers\votre\projet
```

2. Installez les dépendances PHP avec Composer :

```bash
composer install
```

3. Installez les dépendances JavaScript avec NPM :

```bash
npm install
```

4. Créez un fichier `.env.local` à partir du fichier `.env` (si nécessaire) :

```bash
copy .env .env.local
```

5. Configurez votre base de données dans le fichier `.env.local`

6. Lancez le serveur Symfony avec Symfony CLI :

```bash
symfony serve
```

Ou sans Symfony CLI :

```bash
php -S localhost:8000 -t public
```

## 10. Dépannage

### PHP ne fonctionne pas en ligne de commande

- Redémarrez l'invite de commande après avoir modifié les variables d'environnement
- Vérifiez que le chemin vers PHP est correct dans les variables d'environnement

### Extensions manquantes

- Vérifiez que les extensions sont bien dé-commentées dans `php.ini`
- Assurez-vous que le fichier `php.ini` a été sauvegardé
- Redémarrez l'invite de commande ou le serveur PHP

### Erreur de connexion à la base de données

- Vérifiez la configuration dans `.env.local`
- Assurez-vous que la base de données est accessible et en cours d'exécution
- Vérifiez les identifiants de connexion

### Erreur : "npm command not found"

- Vérifiez que Node.js et NPM sont installés : `node -v` et `npm -v`
- Redémarrez votre invite de commande après l'installation
- Vérifiez que le chemin vers Node.js est dans le PATH

### Erreur : "symfony command not found"

- Vérifiez que Symfony CLI est installé : `symfony -v`
- Redémarrez votre invite de commande après l'installation
- Vérifiez que le chemin vers Symfony CLI est dans le PATH

### Composer ou NPM prend du temps

- Utilisez un miroir plus rapide pour Composer :
  ```bash
  composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
  ```
- Pour NPM, utilisez un registre alternatif :
  ```bash
  npm config set registry https://registry.npmjs.org/
  ```

## 11. Ressources Utiles

- Documentation officielle Symfony : https://symfony.com/doc/current/index.html
- Documentation PHP : https://www.php.net/manual/
- Composer : https://getcomposer.org/
- Forum Symfony : https://symfony.com/community
