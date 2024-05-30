FROM php:8.1-cli-bullseye

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    git \
    libpq-dev \
    postgresql-client \
    curl \
    p7zip-full \
    unzip \
    iputils-ping \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    libxml2-dev \
    wget \
    vim && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql intl
RUN docker-php-ext-configure gd && docker-php-ext-install gd
RUN docker-php-ext-configure zip && docker-php-ext-install zip
RUN docker-php-ext-configure soap && docker-php-ext-install soap

RUN pecl install apcu \
	&& docker-php-ext-enable apcu \
	&& echo "apc.enabled=1" >> /usr/local/etc/php/conf.d/apcu.ini \
	&& echo "apc.enable_cli=1" >> /usr/local/etc/php/conf.d/apcu.ini

RUN curl -sL https://github.com/xdebug/xdebug/archive/3.0.0.tar.gz | tar -xz && \
  mkdir -p /usr/src/php/ext/ && \
  mv xdebug-3.0.0 /usr/src/php/ext/xdebug && \
  docker-php-ext-install xdebug && \
  echo "memory_limit = -1" >> /usr/local/etc/php/php.ini && \
  echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
  echo "xdebug.log_level=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app