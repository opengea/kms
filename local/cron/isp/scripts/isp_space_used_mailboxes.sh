#!/bin/bash

DIR=/var/vmail
LOG_PATH=/var/log/kms/cron
LOG=$LOG_PATH/isp_space_used_mailboxes.log
LOG_DETAIL=isp_space_used_mailboxes_detail.log

mkdir -p $LOG_PATH
rm $LOG

for i in $(ls $DIR); do
	echo -e $i;
	du -sb $DIR/$i >> $LOG
	mkdir -p $LOG_PATH/detail/$i
	rm $LOG_PATH/detail/$i/$LOG_DETAIL
	for j in $(ls $DIR/$i); do
		du -sb $DIR/$i/$j >> $LOG_PATH/detail/$i/$LOG_DETAIL
	done
done


