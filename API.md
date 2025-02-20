
# Documentation de l'API Biblio

## Authentification

| Opération | Endpoint  | Méthode   | Authentification | Body (Exemple)                                                                 | Description                                        |
|-----------|-----------|-----------|------------------|------------------------------------------------------------------------------|----------------------------------------------------|
| **Login** | `/login`  | `POST` 🟡 | Public 🔓        |![```json { "username": "admin", "password": "secret" }```](https://files.catbox.moe/q6wlmn.png)  | Retourne un token JWT si les identifiants sont valides |

---

## Livres

| Opération     | Endpoint       | Méthode   | Authentification | Body (Exemple)                                                                 | Description                                  |
|---------------|----------------|-----------|------------------|------------------------------------------------------------------------------|----------------------------------------------|
| **Create**    | `/books`       | `POST` 🟡 | Admin 🔑         | ![```json\n{\n "title": "Le Petit Prince",\n "author_id": 3,\n "published_at": "1943-04-06"\n}\n```](https://files.catbox.moe/ps51pw.png) | Crée un nouveau livre |
| **Read All**  | `/books`       | `GET` 🟢  | Public 🔓        | *(aucun)*                                                                   | Liste tous les livres |
| **Read One**  | `/books/{id}`  | `GET` 🟢  | Public 🔓        | *(aucun)*                                                                   | Récupère un livre par ID |
| **Update**    | `/books/{id}`  | `PUT` 🟣 | Admin 🔑         | ![```json<br>{<br>  "title": "Nouveau Titre",<br>  "author_id": 5<br>}```](https://files.catbox.moe/5uqkyh.png)     | Met à jour un livre |
| **Delete**    | `/books/{id}`  | `DELETE` 🔴 | Admin 🔑       | *(aucun)*                                                                   | Supprime un livre |

---

## Auteurs

| Opération     | Endpoint         | Méthode   | Authentification | Body (Exemple)                                      | Description                            |
|---------------|------------------|-----------|------------------|---------------------------------------------------|----------------------------------------|
| **Create**    | `/authors`       | `POST` 🟡 | Admin 🔑         | ![```json<br>{<br>  "name": "Victor Hugo"<br>}```](https://files.catbox.moe/1s6pot.png)   | Crée un nouvel auteur                  |
| **Read All**  | `/authors`       | `GET` 🟢  | Public 🔓        | *(aucun)*                                         | Liste tous les auteurs                 |
| **Read One**  | `/authors/{id}`  | `GET` 🟢  | Public 🔓        | *(aucun)*                                         | Récupère un auteur par ID              |
| **Update**    | `/authors/{id}`  | `PUT` 🟣 | Admin 🔑         | ![```json<br>{<br>  "name": "Nouveau Nom"<br>}```](https://files.catbox.moe/z4hnrs.png)   | Met à jour un auteur                   |
| **Delete**    | `/authors/{id}`  | `DELETE` 🔴 | Admin 🔑       | *(aucun)*                                         | Supprime un auteur                     |

---

## Utilisateurs

| Opération     | Endpoint       | Méthode   | Authentification | (Body Exemple)                                                                 | Description                                |
|---------------|----------------|-----------|------------------|------------------------------------------------------------------------------|--------------------------------------------|
| **Create**    | `/users`       | `POST` 🟡 | Admin 🔑         | ![```json<br>{<br>  "username": "bob",<br>  "email": "bob@example.com",<br>  "password": "secret",<br>  "is_admin": 0<br>}```](https://files.catbox.moe/qxg4wv.png) | Crée un utilisateur. Le nom d'utilisateur sera de préférence `prénom_nom` |
| **Read All**  | `/users`       | `GET` 🟢  | Admin 🔑         | *(aucun)*                                                                   | Liste tous les utilisateurs |
| **Read One**  | `/users/{id}`  | `GET` 🟢  | Admin 🔑         | *(aucun)*                                                                   | Récupère un utilisateur par ID |
| **Update**    | `/users/{id}`  | `PUT` 🟣 | Admin 🔑         | ![```json<br>{<br>  "username": "alice",<br>  "email": "alice@example.com",<br>  "is_admin": 1<br>}```](https://files.catbox.moe/55zajl.png) | Met à jour un utilisateur |
| **Change Password**    | `/users/{id}/change-password`     | `POST` 🟡| Requise 🔑  (l'utilisateur doit être lui-même ou un admin)            | ![```json<br>{<br>  "old_password": "monAncienMDP",<br>  "new_password": "monNouveauMDP"<br>}```](https://files.catbox.moe/bcvrxn.png) | Permet de changer le mot de passe. L’utilisateur non-admin doit fournir l’ancien mot de passe. Un admin peut forcer le changement sans `old_password`.
| **Delete**    | `/users/{id}`  | `DELETE` 🔴 | Admin 🔑       | *(aucun)*                                                                   | Supprime un utilisateur |

---

## Emprunts

| Opération     | Endpoint        | Méthode   | Authentification | (Body Exemple)                                                       | Description                                   |
|---------------|-----------------|-----------|------------------|--------------------------------------------------------------------|-----------------------------------------------|
| **Create**    | `/borrows`      | `POST` 🟡 | Admin 🔑         | ![```json<br>{<br>  "user_id": 2,<br>  "book_id": 10,<br>  "borrow_date": "2025-01-01"<br>}```](https://files.catbox.moe/qqz4uk.png) | Crée un emprunt |
| **Read All**  | `/borrows`      | `GET` 🟢  | Admin 🔑         | *(aucun)*                                                          | Liste tous les emprunts |
| **Read One**  | `/borrows/{id}` | `GET` 🟢  | Admin 🔑         | *(aucun)*                                                          | Récupère un emprunt par ID |
| **Update**    | `/borrows/{id}` | `PUT` 🟣 | Admin 🔑         | ![```json<br>{<br>  "return_date": "2025-02-01"<br>}```](https://files.catbox.moe/rsvnrp.png)             | Met à jour un emprunt |
| **Delete**    | `/borrows/{id}` | `DELETE` 🔴 | Admin 🔑       | *(aucun)*                                                          | Supprime un emprunt |

---

**Notes techniques** :  
- 🔓 = Route publique  
- 🔑 = Nécessite un token JWT d'un compte admin (`Authorization: <token>`)  
- `{id}` = ID de la ressource (ex: `/books/42`)  
- Format des dates : `YYYY-MM-DD`  
- Les requêtes PUT acceptent des body partiels (mise à jour partielle)  


