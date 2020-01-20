help:
	@echo "make all               -- make sure everything is ready to run"
	@echo "make migrate           -- run pending migrations"
	@echo "make migrate-rollback  -- roll back last migration"
	@echo "make proxies           -- refresh doctrine proxies"
	@echo "make serve             -- start local php server"
	@echo "make test              -- run unit tests"

all: folders migrate proxies

folders:
	mkdir -p var/cache var/data

serve:
	php -S 127.0.0.1:8080 -t public

migrate:
	vendor/bin/doctrine-migrations migrations:migrate -n

migrate-rollback:
	vendor/bin/doctrine-migrations migrations:migrate prev -n

proxies:
	vendor/bin/doctrine orm:generate-proxies

test:
	rm -f var/data/test.sqlite
	APP_ENV=test vendor/bin/doctrine-migrations migrations:migrate -n
	phpunit
