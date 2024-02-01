# Utiliser la dernière version de l'image officielle de MariaDB
FROM mariadb:latest

# Définir le répertoire de travail à l'intérieur du conteneur (équivalent du cd, current directory)
WORKDIR /etc/mysql/

# Copier les fichiers de configuration de MariaDB dans le répertoire de travail
COPY .docker/mariadb/conf/ ./

# my.cnf est un lien symbolique qui pointe sur le fichier de configuration mariadb.cnf
# copié juste avant.
# Les configurations seront ignorées si les droits sont trop permissifs, alors
# on les restreint via chmod
RUN chmod 644 /etc/mysql/my.cnf

# Copier les scripts d'initialisation automatique de la base de données
# Ceuxi-ci seront exécutés au démarrage du conteneur
COPY .docker/mariadb/init/ /docker-entrypoint-initdb.d/

# Exposer le port 3306 du conteneur pour pouvoir y accéder depuis l'extérieur
EXPOSE 3306
