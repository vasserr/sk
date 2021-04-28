FROM composer:latest as composer

###> base stage ###
FROM php:8.0.3-fpm-alpine as base
COPY --from=composer /usr/bin/composer /usr/bin/composer

###> install deps ###
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS git \
    ###< PDO ###
    && apk --no-cache add libpq postgresql-dev \
    && docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql pgsql \
    ###> PDO ###
    && apk del -f .build-deps \
    && rm -r /var/www/html
###< install deps ###

###< base stage ###

###> dev stage ###

FROM base as dev
###> xdebug
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug-3.0.1 \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps
###< xdebug
###> create non root user ###
ARG UID=33
ARG UNAME=www-data
RUN adduser -D -u ${UID} ${UNAME}  || echo "User exists" \
    && addgroup -g ${UID} ${UNAME} || echo "Group ${UNAME} alreay exists"
###< create non root user ###
###> tweak php configs
RUN sed -i -- "s/user = www-data/user = ${UNAME}/g" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i -- "s/group = www-data/group = ${UNAME}/g" /usr/local/etc/php-fpm.d/www.conf
###< tweak php configs
WORKDIR /var/www/app
USER ${UID}
CMD ["php-fpm"]
