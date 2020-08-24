# Employee Laravel Package

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

## For package migration

php artisan migrate --path=packages/Gzc/Employee/src/Database


