FROM php:7.4-fpm

# 必要なPHP拡張モジュールをインストール
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    zlib1g-dev \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql gd zip

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリを設定
WORKDIR /var/www
