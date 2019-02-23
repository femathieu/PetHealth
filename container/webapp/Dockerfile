FROM ubuntu:18.04

RUN apt-get update

RUN apt-get install -y nginx

RUN apt-get install -y php-fpm php-cli php-mysql php-gd php-imagick php-recode php-tidy php-xmlrpc

RUN sed -i -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -e "s/upload_max_filesize\s*=\s*2M/upload_max_filesize = 100M/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -e "s/post_max_size\s*=\s*8M/post_max_size = 100M/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -e "s/;date.timezone\s*=\s*/date.timezone = Europe\/Paris/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -e "s/listen\s*=\s*\/run\/php\/php7.2-fpm.sock/listen = \/var\/run\/php\/php7.2-fpm.sock/g" /etc/php/7.2/fpm/pool.d/www.conf

COPY ./src /var/www/html/

ADD ./container/webapp/start.sh /

CMD ["/bin/bash", "/start.sh"]