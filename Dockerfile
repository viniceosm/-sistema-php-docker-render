FROM php:7.4-apache

# Instala extensões do PostgreSQL
RUN docker-php-ext-install pgsql pdo pdo_pgsql

# Ativa mod_rewrite (se precisar de URLs amigáveis)
RUN a2enmod rewrite

# Copia os arquivos do projeto para o container
COPY src/ /var/www/html/

EXPOSE 80
