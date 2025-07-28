# Usa la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Copia todos los archivos del proyecto al contenedor
COPY . /var/www/html/

# Habilita mod_rewrite (para URLs amigables, si lo usas)
RUN a2enmod rewrite

# Configura permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expone el puerto 80 (por defecto en Apache)
EXPOSE 80
