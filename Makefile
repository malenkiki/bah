all:
	phpdoc -d . -t docs

installtools:
	pear channel-discover pear.phpdoc.org
	pear install phpdoc/phpDocumentor

