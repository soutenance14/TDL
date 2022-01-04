# Contributions
Ce document se base sur le fichier readme du projet [first contributions]( https://github.com/firstcontributions/first-contributions ).


<img align="right" width="300" src="https://firstcontributions.github.io/assets/Readme/fork.png" alt="embrancher ce repertoire" />

Si vous n'avez pas git sur votre ordinateur, [ installez-le ]( https://help.github.com/articles/set-up-git/ ).

## "Forkez" le répertoire (repository)

Forkez le répertoire en cliquant sur le bouton de fork en haut de la page.
Cela va créer une copie du répertoire sur votre compte.

## Clonez ce répertoire

<img align="right" width="300" src="https://firstcontributions.github.io/assets/Readme/clone.png" alt="clonez ce répertoire" />

Maintenant, clonez le répertoire sur votre ordinateur. Cliquez sur le bouton clone puis cliquez sur l'icone *copier dans le presse-papier*.

Ouvrez un invite de commande et exécutez les commandes git suivantes :

```
git clone "l'url que vous venez de copier"
```
où "l'url que vous venez de copier" (sans les guillemets) est l'url du répertoire. Voir la section précédente afin d'obtenir l'url.

<img align="right" width="300" src="https://firstcontributions.github.io/assets/Readme/copy-to-clipboard.png" alt="copier l'URL dans le presse-papier" />

Par exemple :
```
git clone https://github.com/votre-nom-d-utilisateur/tdl.git
```
où `votre-nom-d-utilisateur` est votre nom d'utilisateur GitHub. Ici vous êtes en train de copier le contenu du répertoire `tdl` depuis GitHub sur votre ordinateur.

## Créez une branche

Déplacez-vous dans le répertoire du projet nouvellement cloné (si vous n'y êtes pas encore) :

```
cd tdl
```
Maintenant créez une branche avec le commande `git checkout` :
```
git checkout -b <add-votre-nom>
```

Par exemple :
```
git checkout -b add-pierre-dupont
```
(Le nom de la branche n'a pas besoin de contenir le terme *add*, mais c'est raisonnable de l'inclure parce que l'objectif de cette branche est d'ajouter votre nom à une liste.)

## Effectuez les modifications nécessaires et faites un commit

Maintenant faites un commit des modifications avec la commande `git commit`:
```
git commit -m "Add <description-des-modifications>"
```
en remplaçant `<description-des-modifications>` par un descriptif très bref des mofifications.

## Poussez (push) les modifications vers GitHub

Poussez vos modifications avec la commande `git push` :
```
git push origin <add-votre-nom>
```
en remplaçant `<add-votre-nom>` avec le nom de la branche précédemment créée.

## Soumettez vos changements pour révision

Si vous visitez votre répertoire sur Github, vous verrez un bouton  `Compare & pull request`.  Cliquez sur ce bouton.

<img style="float: right;" src="https://firstcontributions.github.io/assets/Readme/compare-and-pull.png" alt="create a pull request" />

Maintenant soumettez la pull request.

<img style="float: right;" src="https://firstcontributions.github.io/assets/Readme/submit-pull-request.png" alt="submit pull request" />

Si les modifications apportées sont pertinentes, toutes vos modifications apportées seront fusionnées avec la branche master de ce projet.

