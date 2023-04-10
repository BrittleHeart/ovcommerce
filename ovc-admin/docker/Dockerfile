FROM php:8.2-fpm-alpine3.17

WORKDIR /var/www

RUN apk update 

RUN apk add \
  make \
  g++ \
  autoconf \
  libtool \
  libpng-dev \
  libjpeg-turbo-dev \
  libzip-dev \
  libxml2-dev \
  libxml2-utils \
  ncurses-dev \
  build-base \
  bash \
  curl \
  wget \
  unzip \
  zip \
  postgresql-dev \
  imagemagick-dev \
  freetype-dev \
  icu-dev \
  oniguruma-dev \
  vim \
  postgresql-client \
  linux-headers \
  rabbitmq-c \
  rabbitmq-c-dev \
  postfix \
  autoconf \
  libsodium-dev \
  nodejs \
  npm \
  libxslt-dev

RUN docker-php-ext-configure zip
RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install gd -j$(nproc) \
  pdo_pgsql \
  pgsql \
  bcmath \
  mbstring \ 
  exif \
  xsl

RUN docker-php-ext-install opcache
RUN docker-php-ext-install intl
RUN docker-php-ext-install sodium

RUN pecl install amqp
RUN pecl install redis
RUN pecl install xdebug 

RUN docker-php-ext-enable xdebug
RUN docker-php-ext-enable amqp

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV PATH="/root/node_modules/.bin:${PATH}"

RUN echo "alias sf='symfony console'" >> ~/.bashrc

RUN npm i -g yarn

CMD [ "php-fpm" ]

EXPOSE 9000