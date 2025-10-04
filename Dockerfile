FROM php:7.4-apache

# Instala dependências necessárias pro PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql pdo pdo_pgsql

# Ativa mod_rewrite (se quiser URLs amigáveis)
RUN a2enmod rewrite

# Copia o projeto
COPY src/ /var/www/html/

EXPOSE 80
