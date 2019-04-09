FROM ubuntu:18.04

RUN apt-get update

RUN apt-get install mysql-server -y
RUN apt-get install vim -y

RUN sed -i -e "s/bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/g" /etc/mysql/mysql.conf.d/mysqld.cnf

COPY ./container/database/db.sql /
COPY ./container/database/pethealth.sql /
COPY ./container/database/start.sh /

RUN sed -i 's/\r$//' /start.sh

 CMD ["/bin/bash", "/start.sh"]