# Stop the containers specific to this application
# First cut off client access to the applications before stopping the data containers
# to avoid potential data corruption errors
sudo docker stop introdocker-adminer
sudo docker stop introdocker-nginx
sudo docker stop introdocker-php
sudo docker stop introdocker-mariadb