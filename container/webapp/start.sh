#!/bin/sh


service php7.2-fpm start

service nginx start

chgrp -R www-data /var/www

tail -f /start.sh