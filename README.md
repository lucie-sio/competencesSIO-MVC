<div id="top"></div>


<!-- Presentation -->
## Presentation

Cette solution web a pour but de permettre à un étudiant du BTS SIO de répertorier ses projets scolaires ou professionnels en ligne. Il peut ensuite mettre en lien les compétences du référentiel du BTS qu'il a mit en oeuvre dans ces projets.



<!-- ROADMAP -->
## Cahier des charges

- [x] Système de connexion
- [x] Réinitialisation du mot de passe
- [x] Page de première connexion
- [x] Page d'erreur
- [x] Profil - Affichage des données de l'utilisateur
- [ ] Profil - Ajout d'un projet (nom, description, lien, document pdf ?...)
- [ ] Profil - Ajout des compétences, indicateurs, savoirs à un projet
- [ ] Profil - Possibilités de modifier les info perso (mdp, portfolio...)
- [ ] Projet - Page template de visualisation d'un projet
- [ ] Séparation des parties Model et Controller



<!-- DATABASE -->
## Base de données

Ce site s'appuie sur une base de données phpMyAdmin, la connexion est établie avec le système PDO de PHP. Les données sont récupérés depuis la base de données grâce aux requêtes incluses dans le fichier /model-controller/db.php.  
Le fichier "competencesSIO.sql" contient le script SQL de la structure de la base de données utilisée.

![Schéma conceptuel de la base de données](Modèle-conceptuel_CompétencesSIO.jpg?raw=true)



## Outils

* [Bootstrap](https://getbootstrap.com)
* [JQuery](https://jquery.com)



<p align="right">[<a href="#top">Retour en haut de la page</a>]</p>
