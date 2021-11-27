.PHONY: dshell

dshell:
	docker-compose up -d nginx
	docker-compose run --service-ports --rm --entrypoint=bash php
setup:
	composer install
	php artisan key:generate
	php artisan test
	php artisan config:cache
	php artisan migrate --seed
node-assets:
	npm install
	npm run prod
