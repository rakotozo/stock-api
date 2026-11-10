
FROM php:8.3-apache

# Dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        intl \
        zip \
        opcache \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Environnement Symfony
ENV APP_ENV=prod
ENV APP_DEBUG=0
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

WORKDIR /var/www/html

# Configuration Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    && a2enmod rewrite headers \
    && printf '<Directory /var/www/html/public>\n\
    AllowOverride None\n\
    Require all granted\n\
    FallbackResource /index.php\n\
    </Directory>\n' \
    > /etc/apache2/conf-available/symfony.conf \
    && a2enconf symfony

# Copier le projet
COPY . .

# Installation Composer
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

RUN mkdir -p var/cache var/log \
    && php bin/console cache:clear --env=prod --no-debug \
    && chown -R www-data:www-data var


RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

ENV PORT=80

RUN sed -ri 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
