# Arrêter les conteneurs spécifiques à cette application
# Couper d'abord l'accès des clients aux applications avant de stopper les conteneurs de données
# pour éviter des erreurs potentielles de corruption de données
sudo docker stop mydocker-adminer
sudo docker stop mydocker-nginx
sudo docker stop mydocker-php
sudo docker stop mydocker-mariadb