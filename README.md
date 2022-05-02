<div id="top"></div>

<!-- Presentation -->
## Presentation

Projet de site des compétences du BTS SIO. Ce site a pour but de permettre à un étudiant du BTS SIO de répertorié ses projets scolaires/professionnels et de montrer les compétences qu'il a mit en oeuvre dans ce projet.



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
- [ ] Séparation des parties model et controller



<!-- DATABASE -->
## Connexion à la base de données

La connexion se fait avec le système PHP PDO, à une base de données phpMyAdmin. Les informations de connexion doivent être renseignés dans le fichier ./model-controller/db.php dans la fonction "callPDO()".



## Outils

* [Bootstrap](https://getbootstrap.com)
* [JQuery](https://jquery.com)



<p align="right">[<a href="#top">Retour en haut de la page</a>]</p>
