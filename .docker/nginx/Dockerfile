# Use the official Nginx image, based on Alpine Linux
# Alpine is a lightweight and secure Linux distribution that contains only the necessary packages
FROM nginx:stable-alpine

# Set the working directory inside the container (equivalent to cd, current directory)
WORKDIR /var/www/html/

# Copy Nginx configuration files
COPY .docker/nginx/conf/ /etc/nginx/

# Copy application files
# ⚠️ Note: Even though PHP processes the requests,
# Nginx needs to see the files to delegate processing to PHP
# Additionally, Nginx serves static files (images, CSS, JS, etc.)
# It is recommended to use a shared volume between the two containers
COPY ./app/ /var/www/html/

# Make the application accessible on port 8000
EXPOSE 80

# Run Nginx
CMD ["nginx", "-g", "daemon off;"]