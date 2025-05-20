FROM php:7.4-apache

# Instala dependências essenciais
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    nano \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && a2enmod rewrite

# Sobrescreve a configuração padrão do Apache
COPY docker/apache/apache.conf /etc/apache2/sites-available/000-default.conf

# Instala Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer
