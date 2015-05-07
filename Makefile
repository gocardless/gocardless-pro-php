SCHEMA_PATH=
CRANK_PATH =../bin/crank
OUT_PATH=.out
CODE_PATHS=./lib ./tests

test: vendor/
	./vendor/bin/phpunit

docs:
	phpdoc -d ./lib -t docs/api --cache-folder docs/cache

clean_docs:
	rm -r ./docs/api

syntax: vendor/
	./vendor/bin/phpcs --standard=phpcs-ruleset.xml $(CODE_PATHS)

vendor:
	composer install

fixsyntax: vendor
	./vendor/bin/phpcbf --standard=phpcs-ruleset.xml $(CODE_PATHS)

clean:
	mv ./$(OUT_PATH)/vendor .composer_vendor
	rm -r ./.out
