# IntroDocker

![Banner](https://repository-images.githubusercontent.com/688852993/7ca95a62-7c27-4123-9618-b366e4581f83)

IntroDocker is a Docker training project.

While the main learning path is explained here, the files necessary for creating a container or a composition are commented to understand each step.

## Table of Contents

- [IntroDocker](#introdocker)
  - [Table of Contents](#table-of-contents)
  - [Installing Docker](#installing-docker)
    - [WSL (Windows)](#wsl-windows)
    - [Docker CLI](#docker-cli)
  - [Using Docker](#using-docker)
    - [Creating an Image](#creating-an-image)
      - [Dockerfile](#dockerfile)
      - [Starting a Container](#starting-a-container)
      - [Running a Command in a Container](#running-a-command-in-a-container)
      - [Stopping a Container](#stopping-a-container)
      - [Removing a Container](#removing-a-container)
    - [Docker Compose](#docker-compose)
      - [Configuring a Composition](#configuring-a-composition)
        - [Volumes](#volumes)
          - [Types of Volumes](#types-of-volumes)
      - [Starting a Docker Composition](#starting-a-docker-composition)
      - [Stopping a Docker Composition](#stopping-a-docker-composition)
      - [Removing a Docker Composition](#removing-a-docker-composition)

## Installing Docker

To install Docker, there are two main options: Docker/Rancher Desktop (or Dockstation on Linux), and CLI (Command Line Interface) installation. Windows users can use Windows Subsystem Linux (WSL) to install Docker via CLI.

### WSL (Windows)

To install WSL, open PowerShell in administrator mode and enter the following commands:

```powershell
# To set the default WSL version (version 2 is newer, more performant, and recommended)
- wsl --set-default-version 2
# To install the Debian distribution (or another one)
- wsl --install -d Debian
# To ensure that your distribution version is WSL 2
- wsl --set-version Debian 2 
```

Once WSL is installed, you can now install Docker. Use the apt utility from WSL, launched in administrator mode. To execute commands with superuser rights, use the "sudo" prefix (superuser do). Then, it's a series of commands that will install Docker, its engine, and its dependencies.

### Docker CLI

```bash
sudo apt-get remove docker docker-engine docker.io containerd runc
sudo apt-get update
sudo apt-get install docker.io
sudo apt-get install \
  ca-certificates \
  curl \
  gnupg \
  lsb-release
sudo mkdir -m 0755 -p /etc/apt/keyrings
curl -fsSL <https://download.docker.com/linux/debian/gpg> | sudo gpg --dearmor -o
/etc/apt/keyrings/docker.gpg
echo \
 "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg]
https://download.docker.com/linux/debian \
 $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list >
/dev/null
sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin
docker-compose-plugin
sudo service docker start
# On some Linux distributions, replace "service docker start" with:
systemctl start docker
systemctl enable docker
# Finally, to verify that Docker is working, run the "hello-world" test image:
sudo docker run hello-world
```

If everything worked correctly, the terminal should display the following:

```bash
Hello from Docker!
This message shows that your installation appears to be working correctly.

To generate this message, Docker took the following steps:
 1. The Docker client contacted the Docker daemon.
 2. The Docker daemon pulled the "hello-world" image from the Docker Hub.
  (amd64)
 3. The Docker daemon created a new container from that image which runs the
  executable that produces the output you are currently reading.
 4. The Docker daemon streamed that output to the Docker client, which sent it
  to your terminal.

To try something more ambitious, you can run an Ubuntu container with:
 $ docker run -it ubuntu bash

Share images, automate workflows, and more with a free Docker ID:
 https://hub.docker.com/

For more examples and ideas, visit:
 https://docs.docker.com/get-started/
```

⚠️ Note: To avoid having to use "sudo" systematically, you can also add yourself to the Docker group, creating it if it doesn't already exist.

```bash
sudo groupadd docker
sudo usermod -aG docker $USER
```

## Using Docker

### Creating an Image

#### Dockerfile

To create a Docker container, you need to build an image from a file: the Dockerfile. This file will determine, using keywords and commands, what the container should contain and execute.  
The "FROM" keyword means that your image will be built from another existing image, which will be retrieved from Docker Hub (<https://hub.docker.com/>). For example, to create a node project, you can put "FROM node:latest" where "node" is the image name and "latest" is the version tag. If you don't specify a tag, the latest version will be used.  
The "WORKDIR" keyword is equivalent to the "cd" or "current directory" of the terminal, but inside the container. All other Docker commands will be executed from this directory.  
The "COPY" keyword allows you to copy files from a local source to a destination in the container. Use "." on both sides to copy files adjacent to the Dockerfile (unless configured otherwise) into the container's WORKDIR (e.g., COPY . .).  
The "RUN" keyword allows you to execute commands for building and starting the container, and these commands will be executed from the WORKDIR. If the image is cached, these commands might not execute.  
The "CMD" keyword also allows you to execute a command but is not part of the container build steps. If there are multiple CMDs in a Dockerfile, only the last one will execute. It is recommended to use RUN for building & installing and CMD for starting. This command has a particular syntax; the arguments must be in JSON array format (e.g., CMD [ "npm", "run", "start" ]) since there is no intermediate shell to interpret special characters when starting the container.  
The "EXPOSE" keyword declares the ports used by the container. If there are multiple ports, separate them with spaces (e.g., EXPOSE 3000 8080).

An example Dockerfile:

```dockerfile
# Retrieve the latest version of the node image from Docker Hub
FROM node:latest
# Set the container's WORKDIR (equivalent to cd - current directory, inside the container)
WORKDIR /usr/src/app
# Copy files from the host's current directory (the folder containing the Dockerfile) to the container's WORKDIR
COPY . .
# Run the npm install command in the container's WORKDIR to install the node application's dependencies (from the previously copied package.json)
RUN npm install
# Expose port 3000 of the container
EXPOSE 3000
# Run the npm run start command in the container's WORKDIR to start the node application's start script (script from the previously copied package.json)
CMD [ "npm", "run", "start" ]
```

#### Starting a Container

To start a container, you first need to build the image from the Dockerfile. Use the "docker build" command, specifying the path to the Dockerfile (by default, the path is the current directory). You can also specify a name and tag for the image with "--tag".

```bash
# Build the image from the Dockerfile in the current directory and name it "introdocker" with the tag "latest"
docker build --tag introdocker:latest .
```

Once the image is built, you can start a container from it with the "docker run" command. You can specify the container name with "--name" and map a host port to a container port with "-p".

```bash
# Start a container from the "introdocker" image, name it "introdocker-container", and map host port 3000 to container port 3000
docker run --name introdocker-container -p 3000:3000 introdocker
```

#### Running a Command in a Container

To run a command in a container, find the running container's name with `docker ps` and execute the following command:

```bash
# Run the "sh" command in the "introdocker-nginx" container to access the container's shell
docker exec -it introdocker-nginx sh
```

#### Stopping a Container

To stop a container, find the running container's name with `docker ps` and execute the following command:

```bash
# Stop the "introdocker-nginx" container
docker stop introdocker-nginx
```

#### Removing a Container

To remove a container, find the running container's name with `docker ps` and execute the following command:

```bash
# Remove the "introdocker-nginx" container
docker rm introdocker-nginx
```

### Docker Compose

Docker Compose is a tool for defining and running multi-container Docker applications. With Compose, you use a YAML file to configure the application's services. Then, with a single command, you create and start all the services from that configuration.  
The [start.sh](/.docker/start.sh) script starts a composition by rebuilding or not the containers from scratch according to the user's choice (useful for development).

#### Configuring a Composition

Generally, you want to separate each service (web server, database, etc.) into a distinct container to facilitate management. To articulate these containers and link them together to run an application, use Docker Compose. The docker-compose.yml file allows this configuration. Each service must be named and configured in this file.  
In this example, after specifying the Docker Compose version, we define a first web server service with nginx. You can choose to start directly from a Docker Hub image (like with `FROM`) or use a Dockerfile. Here, for building the image, we will use the Dockerfile in the web/nginx/ subfolder:

[Docker Compose](./.docker/docker-compose.yml)

⚠️ Note: It is recommended to delegate as many tasks as possible to the Dockerfile, especially application-specific tasks, to make the docker-compose.yml reusable.

##### Volumes

Volumes allow data to persist when the container shuts down, so you can retrieve it on the next startup. Volumes are crucial for production containers because they allow data to be retained and shared between multiple containers, especially for databases.

###### Types of Volumes

There are several types of volumes, which define how data is stored:

- `bind`: mounts a folder or file from the host to the container. This is the least performant volume type as it uses the host's file system but allows modifying files from the host, recommended for development. Note that if the host folder/file of a volume does not exist, errors may occur.
- `volume`: mounts a folder or file from the container to a Docker volume. This is the most performant volume type, ensuring file persistence when the container shuts down, recommended for production.
- `tmpfs`: mounts a folder or file from the host's RAM to the container. This is the most performant volume type, but data is not persistent, recommended for logs.

These volumes can be named or anonymous. Named volumes are created with the `docker volume create <volume name>` command and are reusable between multiple containers. Anonymous volumes are automatically created by Docker and are tied to a single container.
Characteristics of anonymous volumes:

- They do not require naming management, no cleanup
- They are tied to a single container, allowing them to be deleted along with the container
- They are not reusable
- They are more suited for development
- They allow creating volumes on a single file
Characteristics of named volumes:

- They require naming management, cleanup (e.g., `docker volume rm <volume name>`, `docker volume prune` to delete all unused volumes, `docker compose down --volumes` to delete volumes associated with a Docker composition)
- They are reusable between multiple containers
- They do not allow deleting data along with the container
- They are more suited for production
- They do not allow creating volumes on a single file

An example with both volume types in a docker-compose.yml file:

```yaml
services:
  myservice:
    volumes:
      # Example of a named volume
      - myvolume:/container/path
      # Example of an anonymous volume
      - /host/path:/container/path

# Named volume configuration
volumes:
  myvolume:
    driver: local
    driver_opts:
      type: none
      device: ./host/path
      o: bind
```

The "consistency" directive only exists on MacOS systems and allows defining the data synchronization mode between the host and the container. There are three modes:

- `consistent`: instant synchronization between the host and the container, may cause performance issues if the container writes a lot of data.
- `cached`: host files are read-only for the container, and changes are applied with a delay. This mode is recommended for code. It is more performant than "consistent" and avoids performance issues if the container writes a lot of data.
- `delegated`: container files are read-only for the host, and the container writes to the host with a delay. This mode is recommended for logs.

#### Starting a Docker Composition

To start a Docker composition, navigate to the folder containing the docker-compose.yml file with `cd` and execute the following command:

```bash
# See the different options with docker compose --help
docker compose up
```

#### Stopping a Docker Composition

To stop a Docker composition, navigate to the folder containing the docker-compose.yml file with `cd` and execute the following command:

```bash
# See the different compositions with docker compose ps
docker compose down
```

#### Removing a Docker Composition

To remove a Docker composition, navigate to the folder containing the docker-compose.yml file with `cd` and execute the following command:

```bash
# See the different compositions
docker compose ps
# Remove a composition, its containers, networks, volumes, and associated images
docker compose rm <composition>
```
