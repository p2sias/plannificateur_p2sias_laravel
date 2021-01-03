# Framework PHP

Le framework étudié est Laravel, de la version 6 à 8. 

## Les objectifs de ce cours

- comprendre l'architecture du framework et les concepts
  - Structurer son code
  - Maîtriser l'accès aux données et leur persistance depuis un ORM 
  -  La notion de ressource et de routage
  - L'utilisation des contrôleurs
- Sécuriser son code  et gérer les autorisations applicatives
- Améliorer les temps de développement grâce aux outils du framework


## Les supports

Les supports seront réalisés pendant les cours et mis à  disposition sur moodle dès la fin du cours. 



## Les modalités d'évaluation

### Le code

Le code produit sera déposé de manière régulière sur git. 

Les critères d'évaluation du code seront les suivants : 

- code commenté
- passage de tests unitaires et d'intégration. 

Ces tests seront fournis au préalable et vous aiderons pendant les phases de développement. 

 ### Les concepts

En plus du code, vous fournirez pour chaque étapes clés un document expliquant les concepts mis en œuvre. Ce document devra entièrement être rédigé par vos soins. il sera passé à l'outil de détection de plagiat compilatio et le taux de similitude ne devra pas être supérieur à 15%, sous peine d'être rejeté et non évalué. 

## L'organisation du travail

Toute l'avancée sera réalisée sous forme de projet : à la fin des cours, vous aurez une application fonctionnelle développée tout au long du déroulement du module. 



### Sujet 

L'objectif sera de réaliser une application Web de gestion de tâche collaboratif. Pour utiliser cette application, l'utilisateur devra être enregistré et connecté. Une fois connecté, il pourra consulter/créer/modifier/supprimer des tâches, et y ajouter d'autres utilisateurs, enregistrés eux aussi. 

Une tâche possède un titre, une description, une date de fin (*due_date*),  un propriétaire (lui seul peut la supprimer), une priorité, un état, une catégorie et peut posséder plusieurs documents en pièces jointe. 

Une tâche peut être assignée à un de ces participants. 

Chaque utilisateur peut rajouter des commentaires sur les tâches. Son nom et l'heure et la date du commentaire doivent être gardé, et il est possible d'éditer le commentaire (cela sera marqué sur le commentaire qu'il a été édité) et même de le supprimer.

## Pour vous aider : 
- faire les fichiers de migrations : 

  - https://laravel.com/docs/8.x/migrations
  - Lire la doc pour concernant les bases de données : 

- faire les modèles Eloquents : https://laravel.com/docs/8.x/eloquent

  	- Lire la suite de la doc : il faut rajouter les relations : https://laravel.com/docs/8.x/eloquent-relationships

  Vous pouvez essayer de générer des données au moyen de seeders  et/ou de factories : https://laravel.com/docs/8.x/seeding

Un blog très pertinent  : http://laravel.sillo.org/ 

## Le mcd de l'application

[mcd]: https://raw.githubusercontent.com/NF-yac/todo-b2-20-21/master/database/mcd/todo.svg "MCD de l'application"


## Conclusion de fin de projet

Voici la liste des fonctionnalités implémentées
    * Un utilisateur peut creer un board
    * Un utilisateur peut supprimer un board si il en est le propriétaire
    * Un utilisateur peut mettre à jour un board si il en est le propriétaire
    * Un utilisateur peut ajouter un membre à un board seulement si il est propriétaire de ce board
    * Un utilisateur peut supprimer un membre d'un board seulement si il est propriétaire de ce board
    * Un utilisateur peut voir un board seulement si il y participe ou si il en est le propriétaire
    * Un utilisateur peut quitter un board seulement si il y participe
    * Un utilisateur peut créer une tache dans un board seulement si il est propriétaire du board ou si il participe à celui-ci
    * Un utilisateur peut mettre à jour une tache dans un board seulement si il est propriétaire du board,
      si il participe juste à la tache, il pourra néanmoins modifier le statut de la tache
    * Un utilisateur peut supprimer une tache dans un board seulement si il est propriétaire du board de cette tache
    * Un utilisateur peut ajouter un membre à une tache seulement si il est le propriétaire de la board de cette tache
    * Un utilisateur peut supprimer un membre d'une une tache seulement si il est le propriétaire de la board de cette tache
    * Un utilisateur peut commenter une tache seulement si il y est assigné ou si il est le propriétaire du board de cette tache
    * Un utilisateur peut supprimer un commentaire seulement si il est propriétaire du board de la tache ou se trouve le commentaire
    * Un utilisateur peut quitter une tache seulement si il y participe
    * Un utilisateur peut voir une tache seuleemnt si il participe ou est le propriétaire du board de cette tache
    * Un utilisateur peut creer un compte
    * Un utilisateur peut se connecter si il ne l'est pas déjà
    * Un utilisateur peut se connecter


## Les difficultés rencontrées : 

Dans l'ensemble j'ai pu avancer sans trop de blocages étant donné que je manipulait déjà Laravel l'année dernière,
néanmoins ce projet m'a permis de renforcer mes compétence, les Modèles qui au début me parraissait un peu floue
notement au niveau des relations (utilisation des relations dans les controllers, dans les vue blades, etc...), 
et les Policies sont maintenant aquis grace à un peu de recherche sur la doc Laravel et sur d'autres sites style YouTube, StackOF, Comment ca mar... non rien c'est tout.

    
