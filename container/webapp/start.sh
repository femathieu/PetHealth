#!/bin/sh

chown -R www-data:www-data /var/www/html

service php7.2-fpm start

# service nginx start

tail -f /start.sh