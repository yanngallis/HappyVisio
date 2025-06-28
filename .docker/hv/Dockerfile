FROM php:8.4-apache

RUN mkdir /etc/apache2/sites-available/ssl
COPY .docker/hv/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN printf '[PHP]\ndate.timezone = "Europe/Paris"\n' > /usr/local/etc/php/conf.d/tzone.ini

RUN apt update \
    && apt install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils openssh-client \
    build-essential locales acl mailutils wget libzip-dev unzip zlib1g-dev libicu-dev g++ \
    gnupg gnupg1 gnupg2 libpng-dev libfreetype6-dev libjpeg62-turbo-dev npm

RUN wget -qO- https://deb.nodesource.com/setup_23.x | bash -
RUN apt install -y nodejs

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN docker-php-ext-install exif
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer
RUN composer self-update
RUN composer --version

RUN wget https://get.symfony.com/cli/installer -O - | bash && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN groupadd dev -g 999
RUN useradd dev -g dev -d /home/dev -m

RUN rm -rf /var/lib/apt/lists/*
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

RUN echo "memory_limit = 500G" >> /usr/local/etc/php/conf.d/docker-php-memory-limits.ini
RUN echo "upload_max_filesize = 50M" >> /usr/local/etc/php/conf.d/docker-php-upload.ini
RUN echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/docker-php-post.ini

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt update && apt install yarn

WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www && a2enmod rewrite ssl
ENV LANG C.UTF-8