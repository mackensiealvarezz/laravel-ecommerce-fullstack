# Laravel Ecommerce
This application was built using:
- Laravel
- Inertia.js
- React
- Tailwindcss

# Setup

## First clone the repo
    git clone https://github.com/mackensiealvarezz/laravel-ecommerce-fullstack

## Copy the .env.example
Copy the **.env.example** and rename it to **.env**

## Run docker
I have included a Makefile to make the development environment easier to setup. You just need to run

    make dshell

This command willl build the docker image and take you directly to the container shell after.

After it takes you to the shell, run

    make setup

This command will auto run migrations, test and seed fake data.

# If "make" command isn't working
If for some reason make command isn't working you can run:

    docker-compose up -d nginx
	docker-compose run --service-ports --rm --entrypoint=bash php

After it takes you to the shell run

	composer install
	php artisan key:generate
	php artisan test
	php artisan config:cache
	npm install
	npm run prod
	php artisan migrate --seed


# Without Docker
To run this application without Docker you will need to have the following installed
- php 8
- mysql
- node/npm
- composer

Then run

	composer install
	php artisan key:generate
	php artisan test
	php artisan config:cache
	npm install
	npm run prod
	php artisan migrate --seed

# Testing
To run the test within this application run

    php artisan test
