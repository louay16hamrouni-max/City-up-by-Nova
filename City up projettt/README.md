# CityUp — MVC PHP + Avis & Évaluations

Projet pédagogique construit à partir du ZIP `CityUp_Vierge_HTML_CSS` et organisé selon le workshop **Atelier : Intégration Template**. Design original conservé et deux interfaces intégrées via `require`.

## Lancer dans VS Code

1. Décompresser puis ouvrir le dossier `CityUp_MVC_Avis` dans VS Code.
2. Installer PHP 8.1+ si nécessaire. Ouvrir un terminal à la racine.
3. Exécuter `php -S localhost:8000`.
4. Ouvrir http://localhost:8000/index.php?page=home

**Ne pas ouvrir directement les fichiers PHP avec Live Server** : il faut un serveur PHP. Avec XAMPP, placer le dossier dans `htdocs` et ouvrir `http://localhost/CityUp_MVC_Avis/index.php?page=home`.

## Pages

- Front office : `index.php?page=home`
- Avis et étoiles : `index.php?page=reviews`
- Back office : `index.php?page=dashboard`
- Modération : `index.php?page=moderation`

## Fonctionnalités du module Avis

- Ajouter un avis, note de 1 à 5, sur commerce/événement/lieu existant dans le catalogue.
- Modifier ou supprimer ses avis pendant la session navigateur (jeton de session PHP).
- Consulter les avis **approuvés** seulement.
- Calculer la moyenne par cible sur les seuls avis approuvés.
- Approuver, rejeter ou supprimer depuis l'interface admin.
- Ajouter une cible depuis la page admin.
- Le stockage de la démo est dans `storage/reviews.json` créé automatiquement, avec association `targetId` entre avis et cible (relation logique, analogue à une jointure).

## Architecture

- `index.php` : point d'entrée / routeur via `app/routes.php`.
- `app/Controllers` : logique des pages et validations.
- `app/Models/Review.php` : lecture/écriture et calcul des moyennes.
- `app/Views/pages` : contenu propre aux pages.
- `app/Views/partials` : morceaux communs (head, navbar, sidebar, header, footer, scripts).
- `app/Views/front_layout.php` et `app/Views/layout.php` : assemblage des composants.
- `public/` : design et images d'origine.

## Limites importantes

**Prototype pédagogique, pas une application de production.** La page admin ne possède pas d'authentification ni de vérification du rôle admin ; les actions de modération ne doivent pas être exposées publiquement. Ajouter une authentification serveur + droits avant mise en ligne. Les avis sont attachés à une session, pas à un compte utilisateur. Le stockage JSON ne constitue pas une base SQL, donc **pas de jointure SQL réelle**. Les fiches du template d'origine sont sauvegardées en `localStorage` et ne sont pas encore synchronisées avec le catalogue d'avis, géré séparément par PHP. Intégration BDD/FK et comptes requise pour une version finale.

Les fichiers `public/script.js` utilisent `localStorage` pour les autres modules hérités du template, sans serveur et sans authentification. Aucun avis fictif prérempli : 3 cibles de démonstration seulement.

## Travail GitHub

Créer le repository, ajouter les fichiers, puis :

```bash
git init
git add .
git commit -m "Integrate CityUp templates in MVC and review module"
git branch -M main
git remote add origin https://github.com/USER/REPO.git
git push -u origin main
```

Créer un GitHub Project avec les tâches : intégration Front Office, intégration Back Office, routage MVC, CRUD avis, moyenne, modération, tests, diagrammes UML. Inviter les tuteurs depuis Settings > Collaborators.
