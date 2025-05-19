FROM php:7.4-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ativa o mod_rewrite
RUN a2enmod rewrite

# Substitui a configuração padrão do Apache pelo nosso apache.conf
COPY ./docker/apache/apache.conf /etc/apache2/sites-available/000-default.conf

# Copia os arquivos do app para o container
COPY ./app /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
