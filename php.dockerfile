FROM php:7.2-fpm-alpine
COPY php.ini /usr/local/etc/php
RUN apk add --update autoconf g++ libtool make \
&& docker-php-ext-install sockets \
&& pecl install xdebug \
&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini