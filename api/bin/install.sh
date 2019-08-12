#!/bin/bash
docker-compose   run --rm php composer install
docker-compose run --rm php bin/console doctrine:database:create
docker-compose run --rm php bin/console doc:mig:mig
docker-compose run php bin/console server:run

docker-compose run --rm phpunit
# http://127.0.0.1:8000
