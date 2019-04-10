#!/bin/sh

mkdir /var/www/html/logs

chgrp -R www-data /var/www

service php7.2-fpm start
service nginx start

tail -f /start.sh