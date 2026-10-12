# Créer la première page Symfony

Chaque page de l'application possède une **route**. C'est à partir de cette route que Symfony va appeler une méthode définie dans un contrôleur. La méthode du contrôleur doit retourner une réponse.

## Les attributs

Un **attribut** est une instruction qui permet d'ajouter des informations sur la déclaration d'une classe, d'une méthode ou d'une propriété. Ils permettent de rendre le code plus lisible et de développer plus rapidement.

Par exemple, l'attribut `Route` permet de définir une route (URL) pour une page.

## Le contrôleur

Le contrôleur va générer une réponse en fonction de la requête. Par exemple, il va :
- Appeler les fonctions de requêtes de base de données
- Appeler la vue pour afficher la page

### Responsabilités du contrôleur

Un contrôleur peut :

- Intercepter les superglobales `GET` et `POST`
- Générer un formulaire
- Appeler des fonctions de requête SQL
- Envoyer des données à la vue

Une classe contrôleur peut hériter de la classe abstraite `AbstractController` fournie par Symfony, qui possède des méthodes utiles.

### Exemple : retourner une réponse simple

Le code suivant va retourner une réponse (simple texte) lorsque le client affiche la page d'accueil (route `/`) :

```php
// src/Controller/AppController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route("/")]
    public function home(): Response
    {
        return new Response("Hello World");
    }
}
```

> **Note :** Tous les fichiers PHP qui se trouvent dans le dossier `src` ont un espace de nom commençant par `App`.

## Twig pour créer une page HTML

Pour une maintenance plus confortable, le code HTML est séparé du code PHP. Symfony inclut un moteur de template appelé **Twig**. Il apporte des fonctions utiles et permet de sécuriser les vues. Par exemple, le développeur backend (PHP) peut contrôler les valeurs que le développeur frontend (Twig) va utiliser.

Pour plus d'informations, consultez le site officiel : [twig.symfony.com](https://twig.symfony.com)

### Organisation des fichiers Twig

Les fichiers Twig doivent se trouver dans le dossier `templates`. Il existe par défaut le fichier `base.html.twig` qui contient le code HTML commun à toutes les pages (balises `html`, `head` et `body`).

Pour plus de lisibilité du projet, le dossier `templates` sera organisé en fonction des contrôleurs. Ainsi, les vues liées au contrôleur `AppController` seront incluses dans le dossier `app` (sans majuscule pour les templates).

### Exemple de fichier Twig

```twig
{# templates/app/home.html.twig #}
{% extends "base.html.twig" %}

{% block body %}
    Bonjour à tous
{% endblock %}
```

Cette vue va hériter de `base.html.twig` et redéfinir le contenu du block `body`.

### Intégrer la vue au contrôleur

Il faut ensuite indiquer au contrôleur qu'il doit interpréter la vue et retourner le code HTML généré grâce à la méthode `render()` fournie par `AbstractController` :

```php
// src/Controller/AppController.php

public function home(): Response
{
    return $this->render('app/home.html.twig');
}
```