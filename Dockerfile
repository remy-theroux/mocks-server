FROM php:7.3-cli

COPY . /usr/src/app

RUN docker-php-ext-install pcntl

WORKDIR /usr/src/app

#INSTALL COMPOSER
RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory_limit.ini
RUN curl -sS http://getcomposer.org/installer | php -- --filename=composer && chmod a+x composer  && mv composer /usr/local/bin/composer
RUN echo 'export PATH=~/.composer/vendor/bin:$PATH' >> ~/.bashrc

RUN composer install

CMD [ "php", "./public/index.php" ]