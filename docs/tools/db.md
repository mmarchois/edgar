# Base de données

## MCD


Le diagramme ci-dessous sera modifié au fur et à mesure de l'évolution du MCD.

```mermaid
classDiagram
direction LR

class User {
    uuid*: uuid
    firstName: varchar[100]
    lastName: varchar[100]
    email: varchar[255]
    password: varchar[255]
}

class ShoppingList {
    uuid*: uuid
    name: varchar[100]
}

class ShoppingCategory {
    uuid*: uuid
    name: varchar[100]
    position: integer
}

class ShoppingItem {
    uuid*: uuid
    name: varchar[100]
    bought: boolean
    quantity: integer
    comment?: varchar[255]
    unit?: varchar[5]
    price?: integer
}

class Card {
    uuid*: uuid
    code: varchar[100]
    name: varchar[100]
}

User "1..N" -- "1..1" ShoppingList
User "1..N" -- "1..N" ShoppingList: user_shoppinglist
ShoppingList "1..N" -- "1..1" ShoppingItem
ShoppingItem "1..1" -- "1..N" ShoppingCategory
Card "1..1" -- "1..N" User
```

## Connexion

Pour se connecter au client PostgreSQL, utilisez la commande :

```bash
make dbshell
```

## Migrations

Lorsque vous effectuez des modifications sur les entités doctrine ainsi que sur les fichiers de mapping, vous devez générer une migration pour qu'elle soit versionnée.

Pour générer une migration, utilisez la commande :

```bash
make dbmigration
```

Une fois la migration générée, il faut l'executer. Pour ce faire il existe la commande suivante qui va prendre l'ensemble des migrations non jouées et les executer une à une.

```bash
make dbmigrate
```
