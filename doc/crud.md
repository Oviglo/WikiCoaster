# Créer le CRUD de `Coaster`

Un **CRUD** regroupe les quatre opérations principales que l'on réalise sur des
données :

- **C**reate : créer
- **R**ead : lire
- **U**pdate : modifier
- **D**elete : supprimer

Dans cette partie, nous allons créer ces quatre opérations pour les montagnes
russes représentées par l'entité `Coaster`.

## 1. Préparer le projet

Les commandes Composer et Symfony présentées dans ce document doivent être
exécutées dans le conteneur PHP du projet :

```bash
docker exec -it wcoaster-php bash
```

Vérifiez ensuite que les bundles nécessaires aux formulaires et à Doctrine sont
installés. Dans ce projet, ils sont normalement déjà présents.

## 2. Créer l'entité `Coaster`

Une entité est une classe PHP qui représente une table de la base de données.
Une instance de cette classe représente une ligne de la table.

Lancez :

```bash
php bin/console make:entity Coaster
```

Répondez aux questions du générateur pour créer les propriétés nécessaires. Par
exemple :

| Propriété | Type Doctrine | Exemple de valeur |
| --- | --- | --- |
| `name` | `string` | `Blue Fire` |
| `description` | `text` | `Un coaster rapide...` |

Symfony crée notamment :

```text
src/Entity/Coaster.php
src/Repository/CoasterRepository.php
```

Le fichier `Coaster.php` contient les propriétés de l'entité et leurs méthodes
`get...()` et `set...()`. La commande génère par exemple une structure proche
de celle-ci :

```php
<?php

namespace App\Entity;

use App\Repository\CoasterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoasterRepository::class)]
class Coaster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
```

Les noms et les types des propriétés dépendent de ceux choisis pendant la
création de l'entité. `make:entity` évite d'avoir à écrire cette classe à la main.

## 3. Créer la table dans la base de données

L'entité décrit la table en PHP, mais elle ne la crée pas immédiatement dans la
base de données. Il faut générer puis exécuter une migration :

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

À la question demandant de confirmer l'exécution de la migration, répondre
`yes`.

Lorsque l'entité est modifiée plus tard, il faut recommencer ces deux commandes.

## 4. Créer le formulaire

Le formulaire évite de lire manuellement chaque valeur envoyée avec la méthode
`POST`. Il permet aussi de valider les données avant leur enregistrement.

Générez la classe de formulaire :

```bash
php bin/console make:form CoasterType Coaster
```

La commande crée le fichier `src/Form/CoasterType.php`. Il doit ressembler à
l'exemple suivant :

```php
<?php

namespace App\Form;

use App\Entity\Coaster;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoasterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coaster::class,
        ]);
    }
}
```

Adaptez les champs aux propriétés de votre entité. L'option
`data_class => Coaster::class` indique que les valeurs du formulaire seront
placées dans un objet `Coaster`.

## 5. Créer le contrôleur

Le contrôleur reçoit les requêtes HTTP, utilise les services nécessaires et
retourne une réponse, généralement une page HTML.

Créez le fichier `src/Controller/CoasterController.php` :

```php
<?php

namespace App\Controller;

use App\Entity\Coaster;
use App\Form\CoasterType;
use App\Repository\CoasterRepository;
use App\Service\DescriptionGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoasterController extends AbstractController
{
    #[Route('/coaster/add')]
    public function add(
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $entity = new Coaster();
        $form = $this->createForm(CoasterType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('app_coaster_index');
        }

        return $this->render('coaster/add.html.twig', [
            'coasterForm' => $form,
        ]);
    }

    #[Route('/coaster/')]
    public function index(CoasterRepository $coasterRepository): Response
    {
        $coasters = $coasterRepository->findAll();

        return $this->render('coaster/index.html.twig', [
            'coasters' => $coasters,
        ]);
    }

    #[Route('/coaster/{id}/edit')]
    public function edit(
        Coaster $entity,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $form = $this->createForm(CoasterType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_coaster_index');
        }

        return $this->render('coaster/edit.html.twig', [
            'coasterForm' => $form,
        ]);
    }

    #[Route('/coaster/{id}/delete')]
    public function delete(
        Coaster $coaster,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        if ($this->isCsrfTokenValid(
            'delete'.$coaster->getId(),
            $request->request->get('_token')
        )) {
            $em->remove($coaster);
            $em->flush();

            return $this->redirectToRoute('app_coaster_index');
        }

        return $this->render('coaster/delete.html.twig', [
            'coaster' => $coaster,
        ]);
    }
}
```

## 6. Comprendre l'affichage des données

La méthode `index()` correspond à l'opération **Read**.

```php
#[Route('/coaster/')]
public function index(CoasterRepository $coasterRepository): Response
```

`CoasterRepository` sert à récupérer les objets `Coaster` dans la base de
données :

```php
$coasters = $coasterRepository->findAll();
```

La méthode `findAll()` retourne tous les coasters. Le contrôleur transmet cette
liste à la vue avec la variable `coasters` :

```php
return $this->render('coaster/index.html.twig', [
    'coasters' => $coasters,
]);
```

Créez ensuite `templates/coaster/index.html.twig` :

```twig
{% extends 'base.html.twig' %}

{% block body %}
    <h1>Liste des coasters</h1>

    <a href="{{ path('app_coaster_add') }}">Ajouter un coaster</a>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {% for coaster in coasters %}
                <tr>
                    <td>{{ coaster.name }}</td>
                    <td>{{ coaster.description }}</td>
                    <td>
                        <a href="{{ path('app_coaster_edit', {id: coaster.id}) }}">
                            Modifier
                        </a>

                        <a href="{{ path('app_coaster_delete', {id: coaster.id}) }}">
                            Supprimer
                        </a>

                        <a href="{{ path(
                            'app_coaster_generate_description',
                            {id: coaster.id}
                        ) }}">
                            Générer la description
                        </a>
                    </td>
                </tr>
            {% else %}
                <tr>
                    <td colspan="3">Aucun coaster enregistré.</td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
{% endblock %}
```

Dans Twig, `coaster.name` appelle en réalité la méthode
`Coaster::getName()`.

## 7. Créer un coaster

La méthode `add()` correspond à l'opération **Create**.

### 7.1. Créer et préparer le formulaire

```php
$entity = new Coaster();
$form = $this->createForm(CoasterType::class, $entity);
```

Un objet `Coaster` vide est créé. Symfony construit ensuite le formulaire à
partir de `CoasterType` et le relie à cet objet.

### 7.2. Traiter la requête

```php
$form->handleRequest($request);
```

Lorsque la requête contient des données POST, `handleRequest()` les copie dans
le formulaire. Comme un `Coaster` est associé au formulaire, les setters de
l'entité peuvent être utilisés pour remplir ses propriétés.

### 7.3. Enregistrer

```php
if ($form->isSubmitted() && $form->isValid()) {
    $em->persist($entity);
    $em->flush();

    return $this->redirectToRoute('app_coaster_index');
}
```

Le code vérifie deux choses :

1. le formulaire a bien été envoyé ;
2. ses données sont valides.

`persist()` demande à Doctrine de surveiller le nouvel objet. `flush()` exécute
réellement l'insertion en base de données.

Créez `templates/coaster/add.html.twig` :

```twig
{% extends 'base.html.twig' %}

{% block body %}
    <h1>Ajouter un coaster</h1>

    {{ form_start(coasterForm) }}
        {{ form_widget(coasterForm) }}
        <button type="submit">Ajouter</button>
    {{ form_end(coasterForm) }}

    <a href="{{ path('app_coaster_index') }}">Retour à la liste</a>
{% endblock %}
```

Si le formulaire n'est pas envoyé ou s'il contient une erreur, le contrôleur
réaffiche cette page avec les messages d'erreur du formulaire.

## 8. Modifier un coaster

La méthode `edit()` correspond à l'opération **Update**.

```php
#[Route('/coaster/{id}/edit')]
public function edit(Coaster $entity, ...)
```

La partie `{id}` de la route est dynamique. Par exemple :

```text
/coaster/3/edit
```

Symfony comprend que l'identifiant vaut `3`. Grâce au **param converter**, il
cherche lui-même le `Coaster` correspondant et fournit l'objet à la méthode.

Le formulaire est rempli avec les données de cet objet :

```php
$form = $this->createForm(CoasterType::class, $entity);
```

Après une soumission valide, l'objet existe déjà dans Doctrine. Il suffit donc
de synchroniser ses modifications avec la base de données :

```php
$em->flush();
```

`persist()` n'est pas nécessaire lors d'une modification.

Créez `templates/coaster/edit.html.twig` :

```twig
{% extends 'base.html.twig' %}

{% block body %}
    <h1>Modifier un coaster</h1>

    {{ form_start(coasterForm) }}
        {{ form_widget(coasterForm) }}
        <button type="submit">Enregistrer</button>
    {{ form_end(coasterForm) }}

    <a href="{{ path('app_coaster_index') }}">Retour à la liste</a>
{% endblock %}
```

## 9. Supprimer un coaster

La méthode `delete()` correspond à l'opération **Delete**.

La suppression ne devrait jamais se faire dès qu'une personne ouvre simplement
une URL. On affiche donc une page de confirmation contenant un formulaire.

Créez `templates/coaster/delete.html.twig` :

```twig
{% extends 'base.html.twig' %}

{% block body %}
    <h1>Supprimer le coaster {{ coaster.name }} ?</h1>

    <form method="post">
        <input
            type="hidden"
            name="_token"
            value="{{ csrf_token('delete' ~ coaster.id) }}"
        >

        <button type="submit">Confirmer la suppression</button>
    </form>

    <a href="{{ path('app_coaster_index') }}">Annuler</a>
{% endblock %}
```

Lors de la soumission du formulaire, le contrôleur vérifie le jeton CSRF :

```php
$this->isCsrfTokenValid(
    'delete'.$coaster->getId(),
    $request->request->get('_token')
)
```

Le jeton permet de vérifier que la demande de suppression provient bien d'un
formulaire de l'application. Si le jeton est valide, Doctrine supprime l'objet :

```php
$em->remove($coaster);
$em->flush();
```

`remove()` marque l'objet pour suppression. `flush()` exécute réellement le
`DELETE` dans la base de données.

## 10. Générer une description

La méthode `generateDescription()` retrouve le coaster à partir de l'identifiant
présent dans l'URL, appelle le service qui modifie sa description, puis
enregistre la modification :

```php
$dgs->generateForCoaster($coaster);
$em->flush();
```

Cette méthode n'a pas besoin de `persist()`, car le `Coaster` a déjà été chargé
depuis la base de données.

## 11. Vérifier les routes

Symfony crée automatiquement les noms des routes à partir du nom du contrôleur
et de la méthode. Vérifiez-les avec :

```bash
php bin/console debug:router
```

Le résultat doit notamment contenir :

| Méthode du contrôleur | Nom de la route |
| --- | --- |
| `add()` | `app_coaster_add` |
| `index()` | `app_coaster_index` |
| `edit()` | `app_coaster_edit` |
| `delete()` | `app_coaster_delete` |
| `generateDescription()` | `app_coaster_generate_description` |

Si un nom est différent, utilisez celui affiché par `debug:router` dans les
appels à `path()` et `redirectToRoute()`.

## 12. Tester le CRUD

1. Ouvrir `/coaster/`.
2. Cliquer sur **Ajouter un coaster**.
3. Remplir le formulaire puis valider.
4. Vérifier que le coaster apparaît dans la liste.
5. Cliquer sur **Modifier** et enregistrer une nouvelle valeur.
6. Vérifier que la modification est bien affichée.
7. Cliquer sur **Supprimer**, confirmer puis vérifier que la ligne a disparu.

En cas d'erreur `404`, vérifier que la route existe avec `debug:router`. En cas
d'erreur Twig, vérifier le nom du template et la présence des variables
transmises par le contrôleur.

## A retenir

### L'entité

Une **entité** représente une ligne d'une table sous forme d'objet PHP. Par
exemple, une instance de `Coaster` contient le nom et la description d'une
montagne russe.

### Le repository

Un **repository** sert à lire les entités dans la base de données. Il contient
des méthodes comme `findAll()` et permet d'ajouter des requêtes personnalisées.
Il lit les données ; il ne remplace pas `EntityManagerInterface` pour les
écrire.

### `persist()` et `flush()`

- `persist($entity)` indique à Doctrine qu'il doit surveiller une nouvelle
  entité.
- `remove($entity)` indique qu'une entité doit être supprimée.
- `flush()` envoie les changements en attente vers la base de données.

Pour une création, utiliser `persist()` puis `flush()`. Pour une modification,
un simple `flush()` suffit si l'entité vient déjà de la base de données. Pour
une suppression, utiliser `remove()` puis `flush()`.

### `handleRequest()`

`handleRequest($request)` donne la requête HTTP au formulaire. Il vérifie si une
réponse a été envoyée et copie les données `POST` dans le formulaire et dans
l'objet associé.

Après cet appel, il est possible de vérifier :

```php
$form->isSubmitted() && $form->isValid()
```

### L'injection de dépendances

Symfony fournit automatiquement aux méthodes du contrôleur les objets dont
elles ont besoin :

```php
public function index(CoasterRepository $coasterRepository): Response
```

Ici, il construit ou récupère un `CoasterRepository` puis le passe à la méthode.
C'est l'**injection de dépendances**. Elle évite de créer soi-même les objets avec
`new`, comme ici pour `EntityManagerInterface` ou un service.

### Le param converter

Dans cette route :

```php
#[Route('/coaster/{id}/edit')]
```

`{id}` est une valeur dynamique. Avec ce paramètre de méthode :

```php
public function edit(Coaster $entity, ...): Response
```

Symfony utilise le **param converter** pour rechercher le coaster correspondant
à `{id}`. La méthode reçoit directement un objet `Coaster`, pas seulement un
nombre. Si aucun coaster ne correspond, Symfony retourne normalement une erreur
`404`.