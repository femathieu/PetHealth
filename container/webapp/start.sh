#!/bin/sh

service php7.2-fpm start

service nginx start

tail -f /var/www/html/index.php