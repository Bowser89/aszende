all: help

help: ## Show this help.
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

build: ## build image
	docker-compose build

bash: ## open a bash shell inside php container using docker-compose
	docker-compose exec --user $$(id -u):$$(id -g) php bash

cs-fix: ## run cs-fix on codebase
	docker-compose exec --user $$(id -u):$$(id -g) php bash -c "php vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php --allow-risky yes"

phpstan: ## run phpstan on codebase
	docker-compose exec --user $$(id -u):$$(id -g) php bash -c "php vendor/bin/phpstan analyse --memory-limit=-1 -v"

phpstan-bl: ## run phpstan (create baseline) on codebase
	docker-compose exec --user $$(id -u):$$(id -g) php bash -c "php vendor/bin/phpstan analyse --memory-limit=-1 --generate-baseline"

phpunit: ## run phpunit on codebase
	docker-compose exec --user $$(id -u):$$(id -g) php bash -c "php bin/phpunit"

up: ## run docker-compose env
	docker-compose up -d

down: ## Ends project using docker-compose down
	docker-compose down

ps: ## Lists running containers
	docker-compose ps

restart: ## Restart the project
	make down && make up

setup: ## first run of project
	docker-compose up -d
	docker-compose exec --user $$(id -u):$$(id -g) php bash -c "composer install"
