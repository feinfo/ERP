FROM php:7.4-apache

# Instala extensões e utilitários necessários
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql \
    && a2enmod rewrite

# Instala o Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copia os arquivos do projeto
COPY . /var/www/html

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Instala dependências via composer (no build)
# RUN cd /var/www/html && composer install --no-dev --optimize-autoloader
