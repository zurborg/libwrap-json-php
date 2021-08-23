php=php
perl=perl
composer=composer
phpcs=$(php) vendor/bin/phpcs
phpunit=$(php) vendor/bin/phpunit
yaml2json=$(perl) -MJSON -MYAML -eprint -e'encode_json(YAML::Load(join""=><>))'

all: | vendor test

clean:
	@echo " --> $@"
	git clean -xdf -e vendor

vendor: composer.json
	@echo " --> $@"
	$(composer) --prefer-dist install >composer.out
	rm composer.lock

composer.json: composer.yaml
	@echo " --> $@"
	$(yaml2json) < $? > $@
	git add -v -- $@

test: lint
	@echo " --> $@"
	$(phpcs) --warning-severity=0 --standard=PSR2 src
	$(phpunit) --color=always tests

.lint/%.php: %.php
	@echo " --> $@"
	mkdir -p -- `dirname -- $@`
	$(php) -l $?
	touch $@

lint:
	@echo " --> $@"
	find src tests -name '*.php' -print0 | sed -zr 's|^|.lint/|' | sort -zuV | xargs -0 -r -- $(MAKE) $(MFLAGS) --

.PHONY: all clean vendor test lint
