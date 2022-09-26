# Loco Loco

## Récupérer le projet de zéro

`$ git clone Repository`  
`$ cd loco-loco`  
`$ git checkout develop`  
`$ git pull`


### Installer et récupérer composer

https://getcomposer.org/  

`$ composer install`  
Récupére les vendors.

### Récupérer les variables d'environements

Récupérer le .env.local (à mettre dans la racine du projet).

### Lancer la base de donnée

Start Apache et MySQL sur XAMPP.

Créer sa base de donnée en locale  
`$ php bin/console doctrine:database:create`  
`$ php bin/console make:migration`

Vérifier si la base de donnée a bien été ajouté ou mise à jour sur phpMyAdmin.

---

## Lancement du serveur Symfony  

`$ php -S localhost:8080 -t public`