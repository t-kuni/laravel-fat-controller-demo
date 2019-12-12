#
# Import source code.
#
FROM php:7.3.10-cli-alpine3.10
COPY ./app /app
WORKDIR /app

#
# Build app environment.
#
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"
RUN docker-php-ext-install mbstring sockets \
    && docker-php-ext-enable mbstring sockets

#
# Install backend packages.
#
RUN composer install --no-dev --no-autoloader
RUN composer dump-autoload

CMD ["php", "/app/entrypoint.php"]
