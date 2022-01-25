.PHONY: ci cs test phpunit psalm psalm-baseline phpstan phpstan-baseline stan

ci: phpstan phpunit psalm
cs: phpstan psalm
test: phpunit

phpunit:
	php ./vendor/bin/phpunit -c phpunit.xml.dist

coverage-html:
	php ./vendor/bin/phpunit -c phpunit.xml.dist --coverage-html=./build/coverage/html

psalm:
	./vendor/bin/psalm

psalm-baseline:
	./vendor/bin/psalm --set-baseline=psalm-baseline.xml

phpstan:
	./vendor/bin/phpstan analyse -c phpstan.neon --no-progress

stan: phpstan

stan-baseline:
	./vendor/bin/phpstan analyse -c phpstan.neon --generate-baseline
