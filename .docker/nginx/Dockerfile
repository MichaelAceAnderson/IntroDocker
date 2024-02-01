# Utiliser l'image officielle de Nginx, basée sur Alpine Linux
# Alpine est une distribution Linux légère et sécurisée qui ne contient que les paquets nécessaires
FROM nginx:stable-alpine

# Définir le répertoire de travail à l'intérieur du conteneur (équivalent du cd, current directory)
WORKDIR /var/www/html/

# Copier les fichiers de configuration de Nginx
COPY .docker/nginx/conf/ /etc/nginx/

# Copier les fichiers de l'application
# ⚠️ Note: Même si c'est PHP qui traite les requêtes,
# Nginx a besoin de voir les fichiers pour déléguer le traitement à PHP
# D'autre part, c'est Nginx qui sert les fichiers statiques (images, CSS, JS, etc.)
# Il est recommandé d'utiliser un volume commun entre les deux conteneurs
COPY ./app/ /var/www/html/

# Rendre l'application accessible sur le port 8000
EXPOSE 80

# Exécuter Nginx
CMD ["nginx", "-g", "daemon off;"]