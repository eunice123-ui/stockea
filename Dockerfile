# Usa la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instala la extensión mysqli para MySQL
RUN docker-php-ext-install mysqli

# Habilita mod_rewrite
RUN a2enmod rewrite

# Agrega tipos MIME
RUN echo "AddType text/css .css\nAddType application/javascript .js\nAddType image/jpeg .jpg\nAddType image/png .png" >> /etc/apache2/apache2.conf

# Copia los archivos del proyecto
COPY . /var/www/html/

# Configura permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expone el puerto 80
EXPOSE 80
