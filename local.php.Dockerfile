FROM php:7.4-fpm
WORKDIR /var/www/
RUN apt-get update && apt-get install -y \
        file \
        libcurl4-gnutls-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libgmp-dev \
		libmagickwand-dev \
        libmcrypt-dev\
        libmhash-dev \
        libpng-dev \
        libxml2-dev \
		libzip-dev \
        re2c \
        zlib1g-dev \
        && \
        ln -s /usr/lib/x86_64-linux-gnu/libsybdb.a /usr/lib/ && \
        ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/
RUN docker-php-source extract
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/ && \
    docker-php-ext-configure gmp
RUN docker-php-ext-install -j$(nproc) gd gmp pdo_mysql zip
RUN curl https://pecl.php.net/get/imagick-3.4.4.tgz --output imagick.tgz && \
	printf "\n" | pecl install imagick.tgz && \
	echo "extension=imagick.so" > /usr/local/etc/php/conf.d/docker-php-ext-imagick.ini
RUN docker-php-source delete

ADD local.php.ini /usr/local/etc/php/conf.d/40-custom.ini
