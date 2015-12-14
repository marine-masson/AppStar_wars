#!/usr/bin/env bash
USERNAME='root'
PASSWORD=''
DBNAME='db_starwars'
HOST='localhost'

USER_USERNAME='yoda'
USER_PASSWORD='yoda'

MySQL=$(cat <<EOF
DROP DATABASE IF EXISTS $DBNAME;
CREATE DATABASE $DBNAME DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
DELETE FROM mysql.user WHERE user='$USER_USERNAME' and host='$USER_PASSWORD';
GRANT ALL PRIVILEGES ON $DBNAME.* to '$USER_USERNAME'@'$HOST' IDENTIFIED BY '$USER_PASSWORD' WITH GRANT OPTION;
EOF
)

echo $MySQL | mysql --user=$USERNAME --password=$PASSWORD

php ./database/migrations.php;
php ./database/seeds.php;