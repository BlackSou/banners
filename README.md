# Banners
API for the hit collect

## Stack
- PHP 8.2
- Symfony 6
- NelmioApiDocBundle
- Doctrine
- Postgresql
- UnitTest
- Docker/docker-compose
- Git
- RabbitMQ

## Project structure
```
.
├── bin
├── config
├── docker
│   ├── nginx
│   ├── php-fpm
│   └── postgres
│
├── migrations
├── public
├── src
│   ├── Controller
│   ├── Entity
│   ├── Repository
│   ├── Message
│   └── ...
├── templates
├── test
│   ├── Controller
│   ├── Message
│   └── ...
├── docker-compose.yml
├── README.md
└── ...
```

## The Fast Track
1 Copy and run in the terminal
```
git clone https://github.com/BlackSou/user-crud-symfony.git app
```
2 Run Docker containers(wait few minutes) and open the Docker PHP container
```
docker-compose up --build -d && docker exec -ti php-fpm sh
```
3 Install Composer dependencies
```
composer install
```
4 Run migrations
```
php bin/console doctrine:migrations:migrate
```
5 Run messenger
```
php bin/console messenger:consume async
```

## API Endpoints
http://127.0.0.1:88/api/doc


