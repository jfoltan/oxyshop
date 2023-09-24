# Oxyshop vstupní test

Úkol k přijímacímu pohovoru: vytvoření systému pro registraci uživatelů


## Požadavky

 - Docker

## Spuštění

**V rootu projektu spustit:**

Vytvoření a spsuštění docker kontejnerů:

    docker-compose up -d --build

Otevření příkazového řádku v kontajneru s php

    docker exec -it php82-container bash

   
**A ve spuštěném prostředí zadat následující příkazy:**

 Instalace potřebných balíčků:

     composer install

 Vytvoření databáze pomocí migrace:
 
    php bin/console doctrine:migrations:migrate

## Použití
Aplikace běží na adrese `localhost:8080`, databáze je dostupná na `localhost:3306`.
