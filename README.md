## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --wait` to start the project
4. Run `composer install` to install composer dependencies
5. Run `bin/console doctrine:fixtures:load` to load fixtures in database
6. Run `make testing` to run tests
7. Go to https://localhost/test
