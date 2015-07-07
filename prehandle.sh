#!/bin/sh

source /etc/profile
DEVICE=$1

if [ -f push.txt ]
then
	rm push.txt
fi
rm /var/www/tsPlat/logs/push/*
adb -s $DEVICE uninstall cn.jingling.motu.photowonder
adb -s $DEVICE install /var/www/tsPlat/testservice/upload/push/upload-android.apk
adb -s $DEVICE shell am start -n cn.jingling.motu.photowonder/cn.jingling.motu.photowonder.SplashActivity
sleep 15
android create uitest-project -n push -t 7 -p ./ 
ant  build
adb -s $DEVICE push ./bin/push.jar data/local/tmp
adb -s $DEVICE shell uiautomator runtest push.jar -c com.baidu.push.motu.Pre_Handle
sleep 5
