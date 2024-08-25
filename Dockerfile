# Use an official PHP image as a base
FROM php:8.2-fpm

# Install Nginx
RUN apt-get update && \
    apt-get install -y nginx && \
    rm -rf /var/lib/apt/lists/*

# Create nginx user and group
RUN groupadd -r nginx && useradd -r -g nginx nginx

# Install additional PHP extensions if needed
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf

# Copy application files
COPY . /var/www/html

# Expose ports
EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
