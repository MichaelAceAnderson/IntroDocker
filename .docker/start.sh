# Si ce n'est pas fait, démarrer le service docker

# Tenter d'utiliser systemctl pour démarrer le service docker
sudo systemctl start docker >/dev/null 2>/dev/null
if [ $? -ne 0 ]; 
then
    # Si systemctl ne fonctionne pas, utiliser service
    echo "Systemctl a échoué, utilisation de service pour démarrer Docker"
    sudo service docker start
else
    # Si systemctl a fonctionné 
    echo "Systemctl a réussi à démarrer le service docker"
fi

choix="Invalide par défaut"
# Tant que la réponse n'est pas valide, redemander à l'utilisateur
while [[ -n "$choix" ]] && [[ "$choix" != [Yy] ]] && [[ "$choix" != [Nn] ]]; do
    # Demander à l'utilisateur s'il veut forcer la reconstruction des images et la recréation des conteneurs
    printf "\nVoulez-vous forcer la reconstruction des images et la recréation des conteneurs ? [y/n]\n(par défaut, le conteneur docker compose sera lancé normalement)\n"
    read choix
done

# Si l'utilisateur a saisi Y ou y
if [[ "$choix" == [Yy] ]]; then
    # Script pour démarrer le conteneur compose sans laisser de traces et supprimer les précédents
    sudo docker compose rm -f
    sudo docker compose down
    # Recréer les conteneurs de chaque service sans cache
    sudo docker compose build --no-cache
    # Démarrer le docker-compose en forçant la reconstruction/la mise à jour des images et la recréation des conteneurs
    sudo docker compose up --pull --build --always-recreate-deps --force-recreate --no-deps --remove-orphans
# Si l'utilisateur a saisi N ou n
elif [[ "$choix" == [Nn] ]]  || [ -z $choix]; then
    # Script pour démarrer le conteneur compose normalement
    sudo docker compose up
fi