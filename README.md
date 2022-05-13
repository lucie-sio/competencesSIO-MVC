<div id="top"></div>

<!-- PRESENTATION -->
## Présentation

Cette solution web a pour but de permettre à un étudiant du BTS SIO de répertorier ses projets scolaires ou professionnels en ligne. Il peut ensuite mettre en lien les compétences du référentiel du BTS qu'il a mit en oeuvre dans ces projets.



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table des matières</summary>
  <ol>
    <li><a href="#roadmap">Cahier des charges</a></li>
    <li><a href="#database">Base de données</a></li>
    <li><a href="#tools">Outils</a></li>
  </ol>
</details>



<!-- ROADMAP -->
## Cahier des charges

- [x] Système de connexion
- [x] Réinitialisation du mot de passe
- [x] Page de première connexion
- [x] Page d'erreur
- [x] Profil - Affichage des données de l'utilisateur
- [x] Profil - Possibilités de modifier les info perso (mdp, portfolio...)
- [x] Profil - Ajout d'un projet (nom, description, lien, image...)
- [x] Projet - Page template de visualisation d'un projet
- [x] Projet - Ajout/suppression des indicateurs, savoirs à un projet
- [ ] Projet - Possibilité de modifier ou supprimer un projet
- [ ] Projet - Ajout d'une image au projet (base64 phpMyAdmin)
- [ ] Compétences - Page présentant toutes les compétencess/indicateurs/savoirs du BTS SIO
- [ ] Récapitulatif - Visualisation de tous les indicateurs/savoirs mis en place par l'étudiant (tous projets confondus)
- [x] Séparation des parties Model et Controller



<!-- DATABASE -->
## Base de données

Ce site s'appuie sur une base de données phpMyAdmin, la connexion est établie avec le système PDO de PHP. Les données sont récupérés depuis la base de données grâce aux requêtes incluses dans le fichier /model-controller/db.php.  
Le fichier "competencesSIO.sql" contient le script SQL de la structure de la base de données utilisée.

![Schéma conceptuel de la base de données](Modèle-conceptuel_CompétencesSIO.jpg?raw=true)



<!-- TOOLS -->
## Outils

* [Bootstrap](https://getbootstrap.com)
* [JQuery](https://jquery.com)



<p align="right">[<a href="#top">Retour en haut de la page</a>]</p>
