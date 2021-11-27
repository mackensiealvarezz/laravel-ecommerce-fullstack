FROM php:8-fpm AS base

#install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
#install ext and lib
RUN apt update && apt install -y zlib1g-dev libpng-dev git zip unzip wget libicu-dev  libzip-dev

#enable
RUN docker-php-ext-install exif gd pdo_mysql intl zip

FROM base AS dev

# Install node
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt update && apt install -y vim nodejs

#edit memory limit
RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = 2G' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini


#working dir
WORKDIR /var/www/html
#copy files
COPY . /var/www/html

#setup
RUN composer install --no-dev --no-scripts
RUN composer dump-autoload -o
