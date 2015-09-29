CREATE DATABASE IF NOT EXISTS `igi`;

CREATE USER 'igi_user'@'localhost' IDENTIFIED BY 'QWEqwe123!@#';

GRANT ALL PRIVILEGES ON igi . * TO 'igi_user'@'localhost';

FLUSH PRIVILEGES;