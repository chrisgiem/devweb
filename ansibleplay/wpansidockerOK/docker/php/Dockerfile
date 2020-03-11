FROM debian:buster

RUN apt-get update && \
    apt-get install -y php-fpm php-mysql php-memcache php-curl memcached supervisor

COPY www.conf /etc/php/7.3/fpm/pool.d/
COPY supervisord.conf /etc/supervisor/conf.d/
COPY php.ini /etc/php/7.3/fpm/php.ini
COPY php-fpm.conf /etc/php/7.3/fpm/php-fpm.conf

VOLUME /var/www/html

EXPOSE 9000
CMD ["/usr/bin/supervisord"]
