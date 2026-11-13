SHELL := /bin/bash


MIGRATIONS_DIR ?= application/migrations

export


start:
	docker compose up -d

stop:
	docker compose down

build:
	docker compose up -d --build


logs:
	docker compose logs -f app

shell:
	docker compose exec app bash

mysql:
	docker compose exec db mysql -u ... -p ...


migration:
	@test -n "$(name)" || (echo "Usage: make migration name=Create_users_table"; exit 1)
	@mkdir -p "$(MIGRATIONS_DIR)"
	@file="$(MIGRATIONS_DIR)/$$(date +%Y%m%d%H%M%S)_$(name).php"; \
	printf '%s\n' '<?php' '' 'defined('\''BASEPATH'\'') OR exit('\''No direct script access allowed'\'');' '' 'class Migration_$(name) extends CI_Migration {' '    public function up() {}' '' '    public function down() {}' '}' > "$$file"; \
	echo "Created $$file"


migrate:
	docker compose exec app php public/index.php migrate

migrate-down:
	docker compose exec app php public/index.php migrate version 0

migration-version:
	@test -n "$(version)" || (echo "Usage: make migration-version version=20261113180000"; exit 1)
	docker compose exec app php public/index.php migrate version "$(version)"
