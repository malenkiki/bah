all: generatedoc runtest

installtools:
	pear channel-discover pear.phpdoc.org
	pear install phpdoc/phpDocumentor

generatedoc:
	phpdoc -d . -t docs

runtest:
	phpunit --colors --include-path src/Malenki/Bah/ tests/
