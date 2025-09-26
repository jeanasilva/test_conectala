FROM php:7.4-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql mbstring zip

# Enable apache rewrite
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/

# Ensure writable cache/logs if needed
RUN chown -R www-data:www-data /var/www/html/application/cache /var/www/html/application/logs || true

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
