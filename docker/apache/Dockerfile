FROM composer:2.5 AS composer

FROM php:7.4-apache

# Instala dependências essenciais
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    nano \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip \
    && a2enmod rewrite

# Sobrescreve a configuração padrão do Apache
COPY docker/apache/apache.conf /etc/apache2/sites-available/000-default.conf

# Instala Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# (Opcional) Ajuste de permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
