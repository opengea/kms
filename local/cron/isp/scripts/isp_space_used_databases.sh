#!/bin/bash
LOG_PATH=/var/log/kms/cron/isp
DIR=/var/lib/mysql
LOG=$LOG_PATH/isp_space_used_databases.log
rm $LOG
for i in $(ls $DIR); do
#echo -e $i;
du -bs $DIR/$i >> $LOG
done

