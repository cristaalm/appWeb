# Etapa 1: Instalar dependencias PHP (Composer)
FROM composer:2.8 as vendor
WORKDIR /app
COPY composer.json composer.lock artisan ./
COPY . .
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Etapa 2: Build de assets con Node
FROM node:22.14 as nodebuild
WORKDIR /app
COPY package*.json ./
COPY . .
RUN npm install
RUN npm run build

# Etapa 3: Imagen final con Apache y PHP
FROM php:8.2-apache
WORKDIR /var/www/html

# Instala extensiones necesarias
RUN apt-get update \
    && apt-get install -y libpq-dev zip unzip git \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite headers negotiation \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Establece el DocumentRoot en public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Aplica el cambio en la configuración de Apache
RUN sed -ri "s!DocumentRoot /var/www/html!DocumentRoot ${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/000-default.conf \
    && sed -ri "s!<Directory /var/www/>!<Directory /var/www/html/public>!g" /etc/apache2/apache2.conf \
    && sed -ri "s!AllowOverride None!AllowOverride All!g" /etc/apache2/apache2.conf

# Copia dependencias y código
COPY --from=vendor /app/vendor ./vendor
COPY --from=nodebuild /app/public ./public
COPY --from=nodebuild /app/resources ./resources
COPY --from=nodebuild /app/routes ./routes
COPY --from=nodebuild /app/app ./app
COPY --from=nodebuild /app/storage ./storage
COPY --from=nodebuild /app/bootstrap ./bootstrap
COPY --from=nodebuild /app/config ./config
COPY --from=nodebuild /app/database ./database
COPY --from=nodebuild /app/artisan ./artisan
COPY --from=nodebuild /app/composer.json ./composer.json
COPY --from=nodebuild /app/composer.lock ./composer.lock

# Copia el archivo .htaccess
COPY --from=nodebuild /app/public/.htaccess /var/www/html/public/.htaccess

# Crear los directorios necesarios y asignar permisos correctos
RUN mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions storage/logs \
    && chmod -R 777 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Asegura permisos (solo para desarrollo)
RUN chmod -R 777 /var/www/html \
    && chown -R www-data:www-data /var/www/html

# Expone el puerto que Render usará
EXPOSE 8080

# Comando de inicio
CMD ["apache2-foreground"]
