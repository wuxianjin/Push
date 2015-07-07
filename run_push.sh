#!/bin/bash

source /etc/profile
DEVICE=$1
TAG=$2
CASEID=$3
PUSHTIME=$4
TOTAL=$5
CASENAME=$6
CONTENT=$7
ADDFIELDS=$8
EXPRESULT=$9
PROJECTPATH=/home/chenyuan01/qa/zhl/Push
LOGFILE=/var/www/tsPlat/logs/push/log_$CASENAME.txt
#A=($(awk '{print ;}' ./motu_pushcase.txt))

function execCase(){
	adb -s $DEVICE shell uiautomator runtest push.jar -c com.baidu.push.motu.$CASENAME > $LOGFILE
	if grep -q 'OK' $LOGFILE
	then
		adb -s $DEVICE pull data/local/tmp/push/motu/motu.png /var/www/tsPlat/push_screenshot/$PUSHTIME.png
		echo -e "$PUSHTIME\t$CONTENT\t$ADDFIELDS\t$EXPRESULT\t1\tPASS\t/push_screenshot/$PUSHTIME.png" >> push.txt
	else
		adb -s $DEVICE pull data/local/tmp/push/motu/motu.png /var/www/tsPlat/push_screenshot/$PUSHTIME.png
    		echo -e "$PUSHTIME\t$CONTENT\t$ADDFIELDS\t$EXPRESULT\t1\tFAIL\t/push_screenshot/$PUSHTIME.png" >> push.txt
	fi
	#rm log.txt
}

function switchToEn(){
	adb -s $DEVICE shell uiautomator runtest push.jar -c com.baidu.push.motu.EnSwitch
}

function switchToCh(){
	adb -s $DEVICE shell uiautomator runtest push.jar -c com.baidu.push.motu.ChSwitch
}


if [ "$CASEID" = "1" ]
then
	#android create uitest-project -n push -t 7 -p $PROJECTPATH
	#ant  build
	#adb -s $DEVICE push ./bin/push.jar data/local/tmp
	execCase

elif [ "$CASEID" = "32" ]
then
	execCase
	switchToEn
elif [ "$CASEID" = "$TOTAL" ]
then
	execCase
	mv push.txt ./result/$TAG.txt
	switchToCh
	sh ./DB.sh $DEVICE
else
	execCase
fi

echo "finish"

