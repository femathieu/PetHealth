#!/bin/sh


service php7.2-fpm start

# service nginx start

chown -R www-data:www-data /var/www

tail -f /start.sh