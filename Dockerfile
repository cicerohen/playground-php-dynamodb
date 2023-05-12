FROM php:8-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl


# Install Node.js and Yarn
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y nodejs yarn

RUN docker-php-ext-install zip

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json ./

RUN composer install

COPY . .

EXPOSE 80

CMD [ "sh", "-c", "php-fpm & cd public/javascript && yarn && yarn start"]
