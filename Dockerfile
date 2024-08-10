# Usa una imagen base oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Instala las extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Configura permisos de directorios de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configura el DocumentRoot de Apache para apuntar al directorio `public` de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Copia el archivo de configuración de Apache al contenedor
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Habilita el módulo rewrite de Apache
RUN a2enmod rewrite

# Reinicia Apache para aplicar los cambios
CMD ["apache2-foreground"]

# Expone el puerto 80 para la aplicación
EXPOSE 80
