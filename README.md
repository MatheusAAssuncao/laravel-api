# Laravel API Example
## Docker + Laravel + MySql

Project for studying API REST with Laravel and Mysql running in docker containers.
## Requeriments
- Docker installed or Server with mysql (you can use Xampp ou Laragon)

## Features

- Populate database through Laravel Seeder with resource /database/seeders/data.json;
- An endpoint that filtering and sorting;
- A Postman file to import and test the endpoints at ./laravel-api.postman_collection.json

## Installation

### Using Docker

Just Docker is required to use the application.
<br>
Inside the project folder, run:
```sh
docker-compose up --build -d
```
When the process is finished, it is possible check two containers: laravel-docker (Nginx, PHP, Composer) and laravel-database (MySql).
```sh
docker ps
```
Then, enter into laravel-docker container to execute Laravel migration and create the database structure
```sh
docker exec -it laravel-docker bash
```
Inside the container, run:
```sh
php artisan migrate:refresh --seed
```
It is done!
From outside of the container, Nginx server is visible on http://localhost:9001 and MySql on localhost:9002.
Check .env file to see the connection informations if you want to see data through SGBD.

> Note: This guide was made to facilitate the visualization and is not prepared for development. To continue the development, composer are required, also some changes in dockerfiles/docker-compose.yaml like sharing Laravel and database volumes between container and host.

> Note: project suggested by the <a href="http://www.eae.pt/" target="_blank">East Atlantic Engineering</a> and developed by me (:

## Util
Docker commands to stop and remove all images and containers:
```sh
docker stop $(docker ps -a -q)
```
```sh
docker rmi -f $(docker images -aq)
```
```sh
docker system prune -a -f
```
