# Utiliser une image PHP officielle avec Apache
FROM php:8.1-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copier le code source de l'application dans le conteneur
COPY . /var/www/html/

# Donner les droits à Apache sur le dossier de l'application
RUN chown -R www-data:www-data /var/www/html/

# Exposer le port 80
EXPOSE 80
