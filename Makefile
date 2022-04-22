setup:
	docker build -t supermarket .
run:
	docker run -it --rm supermarket
unitTest:
	docker run -it --rm supermarket vendor/bin/phpunit
behatTest:		
	docker run -it --rm supermarket vendor/bin/behat		
