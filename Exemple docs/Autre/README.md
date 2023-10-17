# El-projet-gps
Notre super projet avec Quentin et Thibaut

## 1) L'IP des machines virtuelles utilisées pour le projet :
    - __192.168.64.148__, l'IP pour accéder au site.  
    - __192.168.65.9__, l'IP pour accéder à la base de données.

-----------------


## 2) LA BASE DE DONNÉES

il est possible d'accéder à la base de données en utilisant le couple identifiant/mot de passe : root/root.
Voici la composition de la base de données :


Lawrence     	
      
      └── user  
        ├── idUser : int (clé primaire)  
        ├── nom : varchar(30)  
        ├── email : varchar(300)  
        └── passwd : varchar (30)  
        └── isAdmin : tinyint (1) 

-----------------


## 3° ORGANISATION DU CODE

* __./addons__
    *readme.md* -> ce même fichier que vous êtes en train de lire pour vous aider à comprendre le code 
    *lawrence.sql* -> un export clean de la base de données afin de pouvoir l'importer dans PhpMyAdmin   

* __./boostrap__
    *contient les fichiers boostraps*

* __./css__  
    *bootstrap.css* -> css utilisé pour les templates bootstraps
    *foot-awesome.min.css* -> gère les polices d'écriture du site
    *login.css* -> gère le css de la page de connexion
    *responsive.css* -> gère le responsive du site
    *style.css* -> gère le css général
    *style.css.map* -> gère le css pour l'affichage de la carte
    *style.scss* ->
    *website.css* ->  
* __./images__    
    *bg.jpg* -> image de background pour les pages de connexion et d'inscription

* __./js__  
    *boostrap.js* -> gère le javascript de la template boostraps
    *jquery.min.js* -> bibliothèque javascript
    *main.js* -> gère le javascript général du site
    *website.js* -> gère la navbar sur toutes les pages et la fermeture de la pop-up de modification
      
* __./utils__  
    *pdo.php* -> se connecte à la base de données

    *session.php* -> gère la session avec l'utilisateur

    *user.php* -> code de la classe user


*accueil.php* -> page d'accueil du site

*compte.php* -> page pour gérer les informations du compte

*index.php* -> page de connexion

*inscription.php* -> page d'inscription