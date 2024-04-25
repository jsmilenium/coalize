<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

Yii 2 Basic Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.4.

INSTALLATION
------------

### Build with Docker

~~~
docker-compose up -d --build
~~~

Run composer install

~~~
docker-compose run --rm php composer install --prefer-dist
~~~

### Run migrations

~~~
docker-compose run --rm php yii migrate
~~~

Change db connection in `config/db.php` to coalize-mysql after migrations

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=coalize-mysql;dbname=yii2_app',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
 ];
```

Update your vendor packages (If necessary)

~~~
docker-compose run --rm php composer update --prefer-dist
~~~

### API

- http://localhost:8080
- [POST] http://localhost:8080/v1/auth/register
- [POST] http://localhost:8080/v1/auth/login
- [POST] http://localhost:8080/v1/auth/logout
- [POST] http://localhost:8080/v1/customer/create
- [GET] http://localhost:8080/v1/customer/index
- [POST] http://localhost:8080/v1/product/create
- [GET] http://localhost:8080/v1/product/index

### Create a new user with curl

```curl
curl --location 'localhost:8080/v1/auth/register' \
--header 'Content-Type: application/json' \
--data '{
    "username": "username",
    "password": "password"
}'
```