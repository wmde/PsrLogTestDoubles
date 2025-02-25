.PHONY: ci cs test phpunit phpstan stan

ci: phpstan phpunit
cs: phpstan
test: phpunit

phpunit:
	php ./vendor/bin/phpunit -c phpunit.xml.dist

coverage-html:
	php ./vendor/bin/phpunit -c phpunit.xml.dist --coverage-html=./build/coverage/html

phpstan:
	./vendor/bin/phpstan analyse -c phpstan.neon --no-progress

stan: phpstan

