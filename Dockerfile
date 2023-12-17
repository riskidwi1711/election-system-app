# Use the official PHP 8.1 image with Apache
FROM php:8.1-apache

# Install required dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo_mysql

# Enable Apache modules and configure the virtual host
RUN a2enmod rewrite
COPY ./laravel.conf /etc/apache2/sites-available/000-default.conf

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy the Laravel application files
COPY . .

# Install Laravel dependencies
RUN composer install --no-interaction --no-scripts --no-dev

RUN composer dump-autoload

# Generate Laravel application key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chown -R www-data:www-data public/uploads/c1

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
