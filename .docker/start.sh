# If not already done, start the docker service

# Attempt to use systemctl to start the docker service
sudo systemctl start docker >/dev/null 2>/dev/null
if [ $? -ne 0 ]; 
then
	# If systemctl fails, use service
	echo "Systemctl failed, using service to start Docker"
	sudo service docker start
else
	# If systemctl succeeds
	echo "Systemctl successfully started the docker service"
fi

choice="Invalid by default"
# While the response is not valid, keep asking the user
while [[ -n "$choice" ]] && [[ "$choice" != [Yy] ]] && [[ "$choice" != [Nn] ]]; do
	# Ask the user if they want to force rebuild images and recreate containers
	printf "\nDo you want to force rebuild images and recreate containers? [y/n]\n(by default, the docker compose container will be started normally)\n"
	read choice
done

# If the user entered Y or y
if [[ "$choice" == [Yy] ]]; then
	# Script to start the compose container without leaving traces and remove previous ones
	sudo docker compose rm -f
	sudo docker compose down
	# Recreate containers for each service without cache
	sudo docker compose build --no-cache
	# Start docker-compose forcing rebuild/update of images and recreation of containers
	sudo docker compose up --pull --build --always-recreate-deps --force-recreate --no-deps --remove-orphans
# If the user entered N or n
elif [[ "$choice" == [Nn] ]] || [ -z $choice ]; then
	# Script to start the compose container normally
	sudo docker compose up
fi