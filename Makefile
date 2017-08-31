THIS := $(realpath $(lastword $(MAKEFILE_LIST)))
HERE := $(shell dirname $(THIS))

fix:
	$(HERE)/vendor/bin/php-cs-fixer fix --config=$(HERE)/.php_cs

lint:
	find -L $(HERE)/src -name '*.php' -print0 | xargs -0 -n1 php -l > /dev/null
	find -L $(HERE)/migrations -name '*.php' -print0 | xargs -0 -n1 php -l > /dev/null

test: fix lint
