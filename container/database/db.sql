UPDATE mysql.user SET authentication_string=PASSWORD("capima") WHERE User='root';
UPDATE mysql.user SET plugin="mysql_native_password" WHERE user='root';

CREATE DATABASE pethealth;

CREATE USER 'web'@'localhost' IDENTIFIED BY 'capima';
CREATE USER 'web'@'%' IDENTIFIED BY 'capima';

GRANT ALL PRIVILEGES ON pethealth.* TO 'web'@'localhost';
GRANT ALL PRIVILEGES ON pethealth.* TO 'web'@'%';

FLUSH PRIVILEGES;

USE pethealth;