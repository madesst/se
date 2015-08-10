
Требования к серверу
----------
 * php >=5.4
 * mysql >=5.6
 * composer >= 1.0
 * databene benerator >= 0.9.8
 * JDK >= 1.8

Benerator и JDK необходимы лишь для генерации данных, вы можете пропустить этот шаг.

Установка
----------
```bash
cd /path/to/project
mysql -uroot -e "create database se;create user se;grant all on se.* to 'se'@'localhost' identified by '=.6q.q74_t7:%*7j_pC*m;%~58|B3*3N';"
composer install
app/console migrations:migrate --no-interaction
benerator.sh ./benerator.xml 
php -S localhost:8080 -t web web/app.php
```