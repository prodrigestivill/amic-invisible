FROM php:cli
RUN pear install -a Mail && pear clear-cache
