# Step 1: Use official PHP 8.2 image with Apache
FROM php:8.2-apache

# Step 2: Set the working directory
WORKDIR /var/www/html

# Step 3: Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    vim unzip git curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Step 4: Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Step 5: Copy the existing application code
COPY . .

# Step 6: Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Step 7: Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Step 8: Expose port 80
EXPOSE 80

# Step 9: Start Apache in the foreground
CMD ["apache2-foreground"]
