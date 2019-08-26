## To  run this project make following command in terminal:

**1. Install Application via composer**

``
composer install
``

**2. Configure database connection**

Set your database connection in .env file.

**3. Create database and tables via Symfony**

~~~
php bin/console doctrine:database:create

php bin/console make:migration

php bin/console doctrine:migrations:migrate
~~~

**4. Start Application**

~~~
php bin/console server:start
~~~