#!/bin/bash

IMEI=$1

HOST='localhost'
PORT='3306'
USER='root'
PWD='sprintkx'

DBNAME="music_autotest_db"
TABLENAME="music_phone"

mysql_login="mysql -h $HOST -P $PORT -u $USER -p$PWD"
mysql_update_sql=''

function mysql_update(){
        mysql_update_sql="update $TABLENAME set is_idle=1 where device_id='$1'"
	${mysql_login} -e "use $DBNAME; $mysql_update_sql"
	if [ $? -ne 0 ] ;then
	    echo "update data faild"
        else
            echo "update data sucess"
    	fi
}

mysql_update $IMEI
