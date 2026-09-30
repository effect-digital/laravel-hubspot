#!/bin/bash

# Start up services defined in docker-compose.yml
docker-compose up -d

# Get the container ID of the PHP service
PHP_CONTAINER=$(docker-compose ps -q laravel-hubspot)

# Open a shell inside the PHP container
docker exec -it "$PHP_CONTAINER" bash
