#!/bin/bash

MYSQL="/usr/bin/mysql"

service mysql stop
usermod -d /var/lib/mysql/ mysql
service mysql start

mysql -e "source /db.sql;";
mysql --user=web --password=capima -e "source /pethealth.sql"

tail -f /start.sh
