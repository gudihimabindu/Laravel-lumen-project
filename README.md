# Lumen PHP Framework

## Clone project and rename .env.example file for Application URL and Database connection update

## Run migrate command

php artisan migrate

## For Task I created new package "Gzc/Employee"

## Update composer.json

"autoload": {
    "psr-4": {
        "Gzc\\Employee\\": "packages/Gzc/Employee/src/"
    }
},
"autoload-dev": {
    "classmap": [
        "packages/Gzc/Employee/src/"
    ]
}

## Register Service provider in bootstarp/app.php

$app->register(\Gzc\Employee\EmployeeServiceProvider::class);

## Fire command

composer update

## For create migration in package use below comand (Note: I already created below migration)
php artisan make:migration create_employees_table --path=packages/Gzc/Employee/src/Database

## For package migration add run below command

php artisan migrate --path=packages/Gzc/Employee/src/Database

## Use below postman collection link for REST APIs

[REST APIs](https://www.getpostman.com/collections/6452a74aee6432edd2b4)

## Postman environment JSON file added in root

Lumen API.postman_environment.json

## For Upload functionality

Please use employee.csv (path: packages/Gzc/Employee) file for formate data to upload employees

## For Queue, use sendnotification API and run below command

php artisan queue:work

## For Unit Test run below command in project root

vendor/bin/phpunit


[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
