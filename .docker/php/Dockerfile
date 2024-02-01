# Image de base
# Pour pouvoir communiquer avec le conteneur Nginx, FPM est nécessaire
# Alpine est une version allégée de Linux qui permet de réduire la taille de l'image
FROM php:8.2-fpm-alpine

# Définir le répertoire de travail à l'intérieur du conteneur (équivalent du cd, current directory)
WORKDIR /var/www/html/

# Installer les dépendances système nécessaires pour toutes les opérations (curl, bash, etc.)
RUN apk update && apk add --no-cache \
	curl \
	bash

# Installer les extensions PHP nécessaires à la communication avec MySQL/MariaDB
RUN docker-php-ext-install pdo pdo_mysql

# Copier les fichiers de configuration de PHP dans le conteneur
COPY .docker/php/conf/ /usr/local/etc/php/

# Puisque Nginx passe les requêtes à PHP-PFM, c'est lui qui doit contenir le code source de l'application
COPY app/ ./

# Rendre PHP accessible sur le port 9000
EXPOSE 9000