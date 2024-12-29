# Use the latest version of the official MariaDB image
FROM mariadb:latest

# Set the working directory inside the container (equivalent to cd, current directory)
WORKDIR /etc/mysql/

# Copy MariaDB configuration files into the working directory
COPY .docker/mariadb/conf/ ./

# my.cnf is a symbolic link pointing to the mariadb.cnf configuration file
# copied just before.
# Configurations will be ignored if permissions are too permissive, so
# we restrict them via chmod
RUN chmod 644 /etc/mysql/my.cnf

# Copy database auto-initialization scripts
# These will be executed at container startup
COPY .docker/mariadb/init/ /docker-entrypoint-initdb.d/

# Expose port 3306 of the container to allow access from outside
EXPOSE 3306
