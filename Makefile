	# @docker run --rm --interactive --tty \
	# 	--volume ${PWD}/src:/app \
	# composer:2.3.10 composer install --ignore-platform-reqs --no-scripts; \
	# docker-compose up --build  --remove-orphans
build-and-serve:
	@docker-compose up --build  --remove-orphans

up:
	@docker-compose up -d

down:
	@docker-compose down

shell:
	@docker-compose exec app sh

shell-nginx:
	@docker-compose exec nginx sh

composer-install:
	@docker-compose exec -T app sh -c "composer install; cp .env.example .env"

composer-add-dev:
	@docker run --rm --interactive --tty \
        --volume ${PWD}/src:/app \
	composer:2.3.10 composer require $(package) --dev --ignore-platform-reqs --no-scripts

composer-add:
	@docker run --rm --interactive --tty \
        --volume ${PWD}/src:/app \
	composer:2.3.10 composer require $(package) --ignore-platform-reqs --no-scripts
