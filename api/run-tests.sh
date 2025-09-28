#docker exec -it php-laravel-api /bin/bash -c 'mysql -u user -ppasspwd -e "CREATE DATABASE IF NOT EXISTS task_manager_testing"'

docker exec -it php-laravel-api /bin/bash -c 'php artisan test --coverage --coverage-html=coverage'
