FROM mysql:5.6.51

COPY my.cnf /etc/mysql/my.cnf

ENV MYSQL_DATABASE safeapp
COPY database.sql /docker-entrypoint-initdb.d/