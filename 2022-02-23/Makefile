build:
	docker-compose build

run: build
	docker-compose up -d
	docker-compose exec php composer install

stop:
	docker-compose stop