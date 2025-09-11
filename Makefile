install:
	composer install

test:
	composer exec phpunit -- tests

lint:
	composer exec phpcs -- src tests --colors --standard=PSR12

lint-fix:
	composer exec phpcbf -- src tests --colors --standard=PSR12
