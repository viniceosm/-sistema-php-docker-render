FROM php:7.4-apache

# Instala extensões necessárias para MySQL
RUN docker-php-ext-install mysqli

# Ativa o mod_rewrite (se precisar no futuro)
RUN a2enmod rewrite

# Copia os arquivos do projeto para a pasta web do Apache
COPY src/ /var/www/html/

EXPOSE 80
