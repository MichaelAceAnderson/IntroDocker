# Image de base
# Pour pouvoir communiquer avec le conteneur Nginx, FPM est nécessaire
# Alpine est une version allégée de Linux qui permet de réduire la taille de l'image
FROM php:fpm-alpine
# Copier le fichier de configuration de PHP
COPY ./web/php/php.ini /usr/local/etc/php/php.ini
# Installer les extensions nécessaires à la connexion aux bases de données
RUN docker-php-ext-install pdo pdo_mysql
# Copier les fichiers du site
# (/!\ nécessaire au fonctionnement de PHP qui doit pouvoir voir les fichiers)
# Note: il est recommandé de définir un volume commun avec Nginx
# pour ne pas avoir deux copies différentes des fichiers en cours de développement
COPY ./www/ /var/www/html
# Rendre PHP accessible sur le port 9000
EXPOSE 9000