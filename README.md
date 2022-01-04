# ToDoList
========
Projet 8 OpenClassroom Parcours Symfony

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/f4d0e9e6d4c24b72b1e1c9f9f828327e)](https://www.codacy.com/gh/soutenance14/TDL/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=soutenance14/TDL&amp;utm_campaign=Badge_Grade)

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1
## Install git
GIT (https://git-scm.com/downloads) 
## Install the project with git
https://github.com/soutenance14/TDL.git
## Use composer
composer install
## Use credentials in the .env file for the database
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
## Use credentials in the .env.test file for the database test
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name_test?serverVersion=5.7
## Create database
php bin/console doctrine:database:create
## Create database for test
php bin/console doctrine:database:create --env=test
## Create migrations
php bin/console doctrine:migrations:migrate
## Create Schema for database test (You can do the same for normal database)
php bin/console doctrine:schema:update --force --env=test
## Launch server
php bin/console server:start
## Load data fixtures
php bin/console doctrine:fixtures:load
## Load data fixtures for test (reload the fixtures test before each test)
php bin/console doctrine:fixtures:load --env=test
## Lauch test
$ php ./vendor/bin/phpunit
## Login User (You can use this credentials)
### Admin
* username: admin
* password: password
### Simple User
* username: user1
* password: password
