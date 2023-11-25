# Dockerimageの指定
FROM php:8.1-fpm-buster
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Package & Library install
RUN apt-get update && \
  apt-get -y install --no-install-recommends git unzip libzip-dev libicu-dev libonig-dev zlib1g-dev mariadb-client vim && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# rootユーザーとして実行している時の警告を無効化
ENV COMPOSER_ALLOW_SUPERUSER 1
# Composerデータを保存するディレクトリの指定
ENV COMPOSER_HOME /composer
# PATH環境変数に`/composer/vendor/bin`を追加
ENV PATH $PATH:/composer/vendor/bin

RUN pecl install xdebug \
&& docker-php-ext-enable xdebug

COPY ./php.ini /usr/local/etc/php/php.ini

# WorkDir Path setting
WORKDIR /data

# Laravel Package install
RUN composer global require "laravel/installer"
