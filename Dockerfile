FROM dunglas/frankenphp

WORKDIR /app

# Dependências do sistema
RUN apt-get update &&  apt upgrade -y && apt-get install -y \
    libjpeg-dev \
    libpng-dev \
    git \
    unzip \
    netcat-openbsd \
    net-tools \
    iputils-ping \
    && rm -rf /var/lib/apt/lists/*

# Extensões PHP necessárias
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache \
    exif \
    pcntl

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia o código da aplicação
COPY . /app

COPY entrypoint.sh /entrypoint.sh

# Dá permissão para o usuário www-data (opcional)
RUN chown -R www-data:www-data /app

# Instala todas as dependências (dev incluídas)
RUN composer install && composer require laravel/octane

# Porta interna do container
EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
