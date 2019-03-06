# bonuses

LOCAL SETUP:
- adjust parameters to your needs in `.env.dist` file or start with default configuration
- `cp .env.dist .env`
- `docker compose up -d --build`
- `docker exec -it bonuses_php_1 bash`
- `composer install`
- `./bin/console doctrine:schema:update --force`
- `./bin/console doctrine:fixtures:load`

LOGIN TO ADMINER:
- server: `mysql`
- user: `root`
- password: `${MYSQL_ROOT_PASSWORD}`
- database: `${MYSQL_DATABASE_NAME}`

Launching php-cs-fixer:
- `cp .php_cs.dist .php_cs`
- `./bin/php-cs-fixer fix ./src/ --config=.php_cs`

Launching tests:
- `cp phpunit.xml.dist phpunit.xml`
- `bin/phpunit --configuration phpunit.xml tests/ --stop-on-failure`

Example credentials for testing:
- username: `user-0`
- password: `password-0`
