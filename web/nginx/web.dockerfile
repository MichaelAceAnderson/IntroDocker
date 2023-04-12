# Image de base
# Alpine est une version allégée de Linux qui permet de réduire la taille de l'image
FROM nginx:stable-alpine
# Copier les fichiers de configuration de Nginx
COPY ./web/nginx/conf/ /etc/nginx/
# Copier les fichiers du site
COPY ./www/ /var/www/html
# Exposer l'application sur le port 80
EXPOSE 80