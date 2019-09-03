# Framework Sixtrone !

Minimum configuration : PHP 7.2
Etape 1 : composer update
Etape 2 : Changer les configurations de base de données dans config/conf.php

# Lancer le serveur PHP

**Command** : php -S localhost:8000 -t public/

## Test unitaire et fonctionnel avec PhpUnit

**Command** : ./vendor/bin/phpunit --colors
Permet de lancer tous les tests
**Command** : ./vendor/bin/phpunit tests/Framework/RendererTest.php
Permet de lancer des tests spécifiques

## Tester le code avec Code Sniffer
**Command** : ./vendor/bin/phpcs
Permet de vérifier la qualité du code

**Command** : ./vendor/bin/phpcs -s
Permet d'identifier les types d'erreurs

**Command** : ./vendor/bin/phpcbf
Permet de corriger les erreurs automatiquement

## Phinx : Versionning de base de données

**Command** : ./vendor/bin/phinx init
Permet d'initialiser Phinx

**Command** : ./vendor/bin/phinx create PostsTable
Permet de créer une classe de migration

**Command** : ./vendor/bin/phinx migrate
Permet d’exécuter les migrations

**Command** : ./vendor/bin/phinx seed:create PostSeeder 
Permet de créer une classe pour la génération de donnée aléatoire

**Command** : vendor/bin/phinx seed:run
Permet d’exécuter les données aléatoires 
