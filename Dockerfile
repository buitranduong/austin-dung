FROM php:8.3-fpm

# COMPOSER_ALLOW_SUPERUSER=1
COPY deploy/php.ini /usr/local/etc/php/php.ini

# Install system dependencies

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libfreetype6-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install zip pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath opcache
RUN docker-php-ext-enable gd
RUN pecl install redis \
   && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Set the working directory to /var/www/html
WORKDIR /var/www/html
# Copy the PHP code file in /app into the container at /var/www/html
COPY .. .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public
RUN chmod g+w /var/www/html/public
RUN chmod -R 775 /var/www/html/storage

#RUN composer install
#RUN composer dump-autoload --optimize
#RUN php artisan key:generate
#RUN php artisan storage:link

RUN echo "session required pam_limits.so" >> /etc/pam.d/php-fpm
# Copy Nginx configuration
COPY ./deploy/nginx.conf /etc/nginx/nginx.conf
COPY ./deploy/www.conf /usr/local/etc/php-fpm.d/www.conf

CMD nginx -t && service nginx start && php-fpm
