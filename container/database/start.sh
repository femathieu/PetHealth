#!/bin/bash

MYSQL="/usr/bin/mysql"

service mysql stop
usermod -d /var/lib/mysql/ mysql

mkdir /var/run/mysqld
touch /var/run/mysqld/mysqld.sock
chown -R mysql /var/run/mysqld

apt-get clean
apt-get -f remove
chown -R mysql:mysql /var/lib/mysql /var/run/mysqld
rm /var/lib/mysql/ib_logfile*
service mysql start

mysql -e "source /db.sql;"
mysql --user=web --password=capima -e "source /pethealth.sql"

tail -f /start.sh
