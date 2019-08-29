# myby

## commands

### installation

```
# docker-compose run --rm php composer install
# docker-compose run --rm php bin/console doctrine:database:create
# docker-compose run --rm php bin/console doc:mig:mig
```

### run

```
# docker-compose run php bin/console server:run # http://127.0.0.1:8000
```

### ci

```
# docker-compose run --rm php-cs-fixer
```

### tests

```
# docker-compose run php bin/console hautelook:fixtures:load
# docker-compose run --rm phpunit

```

### misc

```
# docker-compose run --rm php bin/console make:entity --api-resource
# docker-compose run --rm php bin/console security:encode-password
# curl -X POST -H "Content-Type: application/json" http://localhost:8000/login -d '{"username":"test@example.com","password":"test"}'
```
