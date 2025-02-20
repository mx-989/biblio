# Biblio - Une API de gestion pour bibliothèques communeautaires.

## Guide d'utilisation de l'API : 

[Documentation de l'API](./API.md)

## Introduction

Ce projet a pour objectif de faciliter la vie des responsables de bibliothèques.

## Prérequis

Avant de commencer, assurez-vous d’avoir Docker et Docker Compose installés sur votre machine. Voici comment procéder :

- Utilisateurs macOS et Windows : Téléchargez et installez [Docker Desktop](https://docs.docker.com/get-started/introduction/get-docker-desktop/).
- Utilisateurs Linux : Suivez les instructions de la [Documentation de Docker](https://docs.docker.com/desktop/setup/install/linux/).
- Composer doit être installé sur votre machine. Vous pouvez le télécharger [ici](https://getcomposer.org/download/).

## Configuration

Avant de démarrer le projet, vous devez configurer vos variables d’environnement. Copiez le fichier [.env.sample](./.env.sample) en `.env` et renseignez les valeurs requises :

```sh
cp .env.sample .env
```

- `DB_NAME`: Le nom de votre base de données MySQL (celui utilisé : biblio)
- `DB_USER`: L'utilisateur MySQL 
- `DB_PASSWORD`: Le mot de passe de l'utilisateur MySQL 
- `DB_ROOT_PASSWORD`: Le mot de passe de l'utilisateur MySQL 
- `DB_PORT`: Le port de MySQL (celui utilisé : 3307)
- `PHPMYADMIN_PORT`: Le port de phpMyAdmin (celui utilisé : 8191)

## Comment l'utiliser ?

```sh
cd app && composer install && cd ../
```

Une fois Docker et Docker Compose installés et les variables d’environnement configurées, vous pouvez démarrer le projet avec la commande suivante :

```sh
docker-compose up -d
```

**Explication :**

- `docker-compose`: Commande pour utiliser Docker Compose
- `up`: Démarre les services
- `-d`: Exécute les services en arrière-plan (mode détaché)

Cette commande démarre le serveur Nginx, l’application PHP, la base de données MySQL et phpMyAdmin.

_Et voilà ! Vous disposez maintenant d’un environnement de développement PHP entièrement conteneurisé. Bon développement !_

Vous pouvez importer dans mysql l'export de la database présent dans le fichier [database_export.sql](./database_export.sql). 

Si ça ne marche pas, vous trouverez les instructions SQL textuelles [ici](https://raw.githubusercontent.com/mx-989/biblio/refs/heads/main/database_instructions.md).

Vous pouvez trouver un plan de la database [ici](./database.png).

## Accéder aux services

- Votre API sera disponible à l’adresse [http://localhost:4000](http://localhost:4000)
- La gestion de DB via phpMyAdmin sera accessible à l’adresse [http://localhost:8191](http://localhost:8191).


## Arrêter le projet

Pour arrêter le projet, exécutez la commande suivante :

```sh
docker-compose down
```

## Logs

Pour consulter les logs des services, utilisez la commande suivante :

```sh
docker-compose logs -f
```

Cette commande affiche les logs de tous les services en cours d’exécution. Pour quitter, appuyez sur `Ctrl + C`.

## License

Ce projet est un logiciel open-source sous licence [MIT](https://opensource.org/licenses/MIT).