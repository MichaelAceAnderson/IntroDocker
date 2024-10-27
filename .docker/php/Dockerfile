# Base image
# To communicate with the Nginx container, FPM is necessary
# Alpine is a lightweight version of Linux that helps reduce the image size
FROM php:8.2-fpm-alpine

# Set the working directory inside the container (equivalent to cd, current directory)
WORKDIR /var/www/html/

# Install necessary system dependencies for all operations (curl, bash, etc.)
RUN apk update && apk add --no-cache \
	curl \
	bash

# Install necessary PHP extensions for communication with MySQL/MariaDB
RUN docker-php-ext-install pdo pdo_mysql

# Copy PHP configuration files into the container
COPY .docker/php/conf/ /usr/local/etc/php/

# Since Nginx passes requests to PHP-FPM, it must contain the application's source code
COPY app/ ./

# Make PHP accessible on port 9000
EXPOSE 9000