### Projet mongoDB
* Lavaud Christine
* Botella Laurent
* Galland Adeline
* Gao Tian
#### Installation
##### Installation de git sur Debian
* sudo apt-get update
* sudo apt-get install git-core
* git config --global user.name "mon pseudo"
* git config --global user.email laurent@example.fr
* git config --list
##### Recuperation du dossier
* git clone https://github.com/gnondpom09/tp_mongo.git
* npm i -g sass (si nodejs installé)
#### Outils de gestion de projet
* https://www.notion.so/
* https://slack.com
#### Base de données 
* Adresse : mongodb://localhost:27017
* Nom de la base : geo_france
#### Modifications
##### Travail sur le style
* Se placer dans la racine du projet
Lancer la commande suivante pour compiler automatiquement le scss en css
* sass --watch scss:css
* Travailler sur le fichier scss/style.scss
Toujours travailler sur la branche dev et récupérer les éventuelles mises à jour du code avant chaque mise à jour.
Une fois la mise à jour terminée sur la branche dev, se placer sur la branche master et envoyer la modification :
* git checkout master 
* git pull
* git checkout dev
* modification du code
* git add monfichier.php
* git status
* git commit -m "ma modif"
* git checkout master 
* git merge test
* git pull 
* git push

