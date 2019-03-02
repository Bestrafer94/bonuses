# bonuses

LOCAL SETUP:
- adjust parameters to your needs in `.env.dist` file or start with default configuration
- `cp .env.dist .env`
- `docker compose up -d --build`

LOGIN TO ADMINER:
- server: `mysql`
- user: `root`
- password: `${MYSQL_ROOT_PASSWORD}`
- database: `${MYSQL_DATABASE_NAME}`

Launching php-cs-fixer:
`cp .php_cs.dist .php_cs`
`./bin/php-cs-fixer fix ./src/ --config=.php_cs`
