#!/bin/bash

docker exec -it php-laravel-api /bin/bash -c 'php artisan test --coverage --coverage-html=coverage'
