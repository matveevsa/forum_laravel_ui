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