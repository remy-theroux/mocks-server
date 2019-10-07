FROM php:7.3-cli

COPY . /usr/src/app

RUN docker-php-ext-install pcntl

WORKDIR /usr/src/app

CMD [ "php", "./public/index.php" ]