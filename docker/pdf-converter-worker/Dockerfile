###> ARGUMENTS ###
ARG PHP
ARG NAME
###< ARGUMENTS ###

###> PHP IMAGE FORM ARGUMENTS ###
FROM $PHP
###< PHP IMAGE FORM ARGUMENTS ###

###> LOCALE ENV ###
ENV MUSL_LOCPATH="/usr/share/i18n/locales/musl" \
    LC_NUMERIC="ru_RU.UTF-8" \
    LC_TIME="ru_RU.UTF-8" \
    LC_COLLATE="ru_RU.UTF-8" \
    LC_MONETARY="ru_RU.UTF-8" \
    LC_MESSAGES="ru_RU.UTF-8" \
    LC_PAPER="ru_RU.UTF-8" \
    LC_NAME="ru_RU.UTF-8" \
    LC_ADDRESS="ru_RU.UTF-8" \
    LC_TELEPHONE="ru_RU.UTF-8" \
    LC_MEASUREMENT="ru_RU.UTF-8" \
    LC_IDENTIFICATION="ru_RU.UTF-8"
###< LOCALE ENV ###

RUN set -xe \
    ###> BASE UTILS ###
    && apk add --update --no-cache \
        openrc \
        bash \
        vim \
        icu \
        libreoffice \
        supervisor \
    ###> LOCALE EXTENSION ### \
        musl-locales \
        musl-locales-lang \
    ###> DEV EXTENSION ###
        make \
        $PHPIZE_DEPS \
        zlib-dev \
        icu-dev \
        libzip-dev \
        g++

RUN \
    ###> CONFIGURE PHP EXTENSIONS
        docker-php-ext-configure intl \
    ###< CONFIGURE PHP EXTENSIONS
    \
    ###> INSTALL PHP EXTENSIONS
        && docker-php-ext-install -j$(nproc)  \
            intl \
            opcache \
            exif \
    ###< INSTALL PHP EXTENSIONS \
    \
    ###> CACHE CLEAR ### \
    && apk del --no-cache \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        make \
        $PHPIZE_DEPS \
        zlib-dev \
        icu-dev \
        libzip-dev \
    && rm -rf /tmp/* \
    && { find /usr/local/lib -type f -print0 | xargs -0r strip --strip-all -p 2>/dev/null || true; } \
    && rm -rf /tmp/* /usr/local/lib/php/doc/* /var/cache/apk/*
    ###< CACHE CLEAR ###


CMD ["/usr/bin/supervisord"]
