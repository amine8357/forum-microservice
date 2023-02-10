FROM php:7.4-fpm-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1


#install git and bash
RUN apk --no-cache update && apk --no-cache add git bash


#install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"  \
    && php composer-setup.php && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

COPY ./ ./

WORKDIR /var/www/html/forum-microservice
# install symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && cp /root/.symfony5/bin/symfony /usr/local/bin/symfony \
    && export PATH="$HOME/.symfony5/bin:$PATH"
RUN composer install
RUN symfony serve -d