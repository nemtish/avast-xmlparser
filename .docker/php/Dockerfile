ARG PHP_VERSION="8.0"
ARG ALPINE_VERSION="3.13"
FROM php:${PHP_VERSION}-alpine${ALPINE_VERSION}

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
COPY . /app
WORKDIR /app
RUN composer install --prefer-source --no-interaction
ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"