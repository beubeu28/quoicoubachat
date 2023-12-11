Pour visualiser notre site web, il vous faut
  - installer symfony
  - installer Nodejs : https://nodejs.org/en

Lancement du projet :
  - ouvrir le projet dans vscode
  - supprimer tous les fichiers de migration
  - ouvrir un terminal et se placer dans le fichier du projet
      - symfony console doctrine:database:create avec le nom "quoicoubachat"
      - symfony console make:migration
      - symfony console doctrine:migration:migrate
      - symfony console doctrine:fixtures:load
  -importer le fichier data.sql dans la base de données via phpmyadmin
  -aller dans le fichier php.ini de votre dossier C:/xampp
  -décommenter extension=intl
  -mettre à jour les composer avec "composer update"
  -lancer votre serveur local avec xampp
  -lancer votre serveur local symfony avec la commande "symfony serve"
  -aller sur l'adresse qui vous est donnée
  -Vous pouvez désormais regarder le projet.
