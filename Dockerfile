# Usa la imagen oficial de PHP con Apache
FROM php:8.1-apache

# ✅ Instala la extensión mysqli necesaria para conectar con MySQL
RUN docker-php-ext-install mysqli

# Habilita mod_rewrite (para URLs amigables, si lo usas)
RUN a2enmod rewrite

# ✅ Agrega tipos MIME directamente a la configuración de Apache
RUN echo "AddType text/css .css\nAddType application/javascript .js\nAddType image/jpeg .jpg\nAddType image/png .png" >> /etc/apache2/apache2.conf

# Copia todos los archivos del proyecto al contenedor
COPY . /var/www/html/

# Configura permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expone el puerto 80 (por defecto en Apache)
EXPOSE 80
