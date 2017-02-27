#!/bin/bash

docker-compose exec php-fpm vendor/phpunit/phpunit/phpunit -c phpunit.xml --coverage-text=var/logs/coverage.log $1
