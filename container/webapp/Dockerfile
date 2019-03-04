FROM ubuntu:18.04

RUN apt-get update --fix-missing
RUN apt-get install -y tzdata
RUN dpkg-reconfigure --frontend noninteractive tzdata

RUN apt-get install -y nginx

RUN apt-get install -y php7.2-fpm php7.2-cli php7.2-mysql php7.2-gd php7.2-imagick php7.2-recode php7.2-tidy php7.2-xmlrpc

RUN sed -i -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -e "s/upload_max_filesize\s*=\s*2M/upload_max_filesize = 100M/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -e "s/post_max_size\s*=\s*8M/post_max_size = 100M/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -e "s/;date.timezone\s*=\s*/date.timezone = Europe\/Paris/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -e "s/listen\s*=\s*\/run\/php\/php7.2-fpm.sock/listen = \/var\/run\/php\/php7.2-fpm.sock/g" /etc/php/7.2/fpm/pool.d/www.conf
RUN sed -i -e "s/;extension=pdo_mysql/extension=pdo_mysql/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -e "s/pdo_mysql.default_socket=/pdo_mysql.default_socket=\/var\/run\/mysqld\/mysqld.sock/g" /etc/php/7.2/fpm/php.ini


COPY ./src/ /var/www/html/src

ADD ./container/webapp/start.sh /

CMD ["/bin/bash", "/start.sh"]