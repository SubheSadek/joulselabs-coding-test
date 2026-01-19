# ===============================
# Makefile for Laravel + Docker
# ===============================

# Containers
PC=php
NG=nginx
PG=postgres
CS=composer
ART=artisan

# Docker Compose commands
DC=docker compose
UP=$(DC) up -d
DOWN=$(DC) down
BUILD=$(DC) build --no-cache

# -------------------------------
# Main commands
# -------------------------------

# Start all containers
up:
	$(UP)

# Stop all containers
down:
	$(DOWN)

# Restart all containers
rs:
	$(DOWN) && $(UP)

# Rebuild all containers
build:
	$(BUILD)

# Enter PHP container shell
sh:
	$(DC) exec $(PC) sh

# Enter Composer container shell
composer:
	$(DC) run --rm $(CS) composer $(filter-out $@,$(MAKECMDGOALS))
	@echo "Composer command executed successfully."

# # Run migrations
migrate:
	$(DC) exec $(PC) php database/migrate.php

migrate-fresh:
	$(DC) exec $(PC) php database/migrate_fresh.php

# Tail logs for all containers
logs:
	$(DC) logs -f
