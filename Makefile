start:
	php artisan serve
test:
	php artisan test
tinker:
	php artisan tinker
phpunit:
	vendor/phpunit/phpunit/phpunit
clear:
	php artisan cache:clear
	php artisan route:cache
setup:
	touch database/database.sqlite
	cp -n .env.example .env || true
	composer install
	php artisan key:generate
	npm install